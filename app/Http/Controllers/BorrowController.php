<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    // Display borrow records for the librarian
    public function index()
    {
        // Total statistics for librarian dashboard
        $totalBorrowedBooks = Borrow::count();
        $totalReturnedBooks = Borrow::whereNotNull('returned_at')->count();
        $totalFinesIssued = Borrow::sum('fine');

        // Example borrowing trends data (should ideally be dynamic based on real data)
        $borrowingTrendsLabels = Borrow::selectRaw('MONTHNAME(borrowed_at) as month')
            ->groupBy('month')
            ->pluck('month')
            ->toArray();
        $borrowingTrendsData = Borrow::selectRaw('COUNT(*) as count')
            ->groupByRaw('MONTH(borrowed_at)')
            ->pluck('count')
            ->toArray();

        // Example fines collected data (should ideally be dynamic based on real data)
        $finesCollectedLabels = Borrow::selectRaw('MONTHNAME(borrowed_at) as month')
            ->groupBy('month')
            ->pluck('month')
            ->toArray();
        $finesCollectedData = Borrow::selectRaw('SUM(fine) as total_fine')
            ->groupByRaw('MONTH(borrowed_at)')
            ->pluck('total_fine')
            ->toArray();

        // Fetch borrow records
        $borrows = Borrow::with(['user', 'book'])->latest()->get();

        return view('librarian.borrow.index', compact(
            'totalBorrowedBooks',
            'totalReturnedBooks',
            'totalFinesIssued',
            'borrowingTrendsLabels',
            'borrowingTrendsData',
            'finesCollectedLabels',
            'finesCollectedData',
            'borrows'
        ));
    }

    // Borrow a book (for users)
public function borrow(Request $request, Book $book)
{
    $user = auth()->user();

    // Check if the book is available
    if ($book->copies_available <= 0) {
        return redirect()->route('books.show', $book->id)->with('error', 'Book is not available for borrowing.');
    }

    // Create a new borrow record
    $borrow = Borrow::create([
        'user_id' => $user->id,
        'book_id' => $book->id,
        'borrowed_at' => now(),
        'due_date' => now()->addDays(14), // Example: 2-week loan
    ]);

    // Decrement the book's available copies
    $book->decrement('copies_available');

    return redirect()->route('user.borrow.index')->with('success', 'Book borrowed successfully!');
}

    // Borrow a book (for users)
    public function borrowBook(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::find($request->book_id);

        if (!$book || $book->quantity <= 0) {
            return redirect()->back()->with('error', 'Book is not available for borrowing.');
        }

        // Create a new borrow record
        $borrow = Borrow::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14), // Default 2-week borrowing period
        ]);

        // Reduce book quantity
        $book->decrement('quantity');

        return redirect()->back()->with('success', 'Book borrowed successfully!');
    }

    // Mark a book as returned (for librarians)
    public function returnBook($id)
    {
        $borrow = Borrow::findOrFail($id);

        if ($borrow->returned_at) {
            return redirect()->back()->with('info', 'Book has already been returned.');
        }

        // Mark book as returned and calculate the fine if overdue
        $borrow->returned_at = now();
        $borrow->fine = $this->calculateFine($borrow);
        $borrow->save();

        // Increment the book's quantity
        $borrow->book->increment('quantity');

        return redirect()->back()->with('success', 'Book returned successfully!');
    }

    // Calculate fine for overdue books
    private function calculateFine(Borrow $borrow)
    {
        $dueDate = $borrow->due_date;
        $returnedDate = now();

        if ($returnedDate > $dueDate) {
            $daysOverdue = $returnedDate->diffInDays($dueDate);
            return $daysOverdue * config('library.fine_per_day', 5); // Default fine per day is 5
        }

        return 0;
    }

    // Generate borrowing statistics for admin dashboard
    public function stats()
    {
        $totalBorrowedBooks = Borrow::count();
        $totalReturnedBooks = Borrow::whereNotNull('returned_at')->count();
        $totalFinesIssued = Borrow::sum('fine');

        return view('admin.dashboard', compact(
            'totalBorrowedBooks',
            'totalReturnedBooks',
            'totalFinesIssued'
        ));
    }
    public function userBorrowedBooks()
    {
        $userId = auth()->id();
    
        // Fetch the books borrowed by the logged-in user
        $borrowedBooks = Borrow::with('book')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    
        return view('user.borrowed_books', compact('borrowedBooks'));
    }
}
