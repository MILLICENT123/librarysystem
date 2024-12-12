<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Book;
use App\Models\User;

class LibrarianController extends Controller
{
    public function index()
    {
        // You can use this method for displaying any index page or listing books if required.
        return view('librarian.borrow.index');
    }

    public function dashboard()
    {
        // Fetch data for the dashboard
        $totalBorrowedBooks = Borrow::count(); // Total number of borrowed books
        $totalReturnedBooks = Borrow::whereNotNull('returned_at')->count(); // Total number of returned books
        $totalFinesIssued = Borrow::sum('fine'); // Total fines issued

        // Borrowing trends (e.g., per month)
        $borrowingTrendsLabels = Borrow::selectRaw("DATE_FORMAT(borrowed_at, '%M') as month")
            ->groupBy('month')
            ->orderByRaw('MIN(borrowed_at)')
            ->pluck('month')
            ->toArray();

        $borrows = Borrow::with('user', 'book') // Ensure user and book relationships are loaded
            ->orderBy('borrowed_at', 'desc')
            ->take(10) // Example: Get the 10 most recent borrow records
            ->get();
    
        $borrowingTrendsData = Borrow::selectRaw('COUNT(*) as count')
            ->groupByRaw("DATE_FORMAT(borrowed_at, '%Y-%m')")
            ->pluck('count')
            ->toArray();

        // Fines collected trends (e.g., per month)
        $finesCollectedLabels = Borrow::selectRaw("DATE_FORMAT(borrowed_at, '%M') as month")
            ->groupBy('month')
            ->orderByRaw('MIN(borrowed_at)')
            ->pluck('month')
            ->toArray();

        $finesCollectedData = Borrow::selectRaw('SUM(fine) as total')
            ->groupByRaw("DATE_FORMAT(borrowed_at, '%Y-%m')")
            ->pluck('total')
            ->toArray();

        // Pass data to the dashboard view
        return view('librarian.dashboard', compact(
            'totalBorrowedBooks',
            'totalReturnedBooks',
            'totalFinesIssued',
            'borrows',
            'borrowingTrendsLabels',
            'borrowingTrendsData',
            'finesCollectedLabels',
            'finesCollectedData'
        ));
    }

    public function tracking()
    {
        // Fetch borrowed books data
        $borrows = Borrow::with('user', 'book')->orderBy('borrowed_at', 'desc')->get();
        
        // Calculate the total number of books borrowed by each user
        $userBorrowCounts = $borrows->groupBy('user_id')->map(function ($borrowGroup) {
            return $borrowGroup->count();
        });
        
        // Calculate total number of books borrowed
        $totalBorrowedBooks = $borrows->count();
        
        // Prepare data for the chart
        $userNames = $userBorrowCounts->keys();
        $borrowCounts = $userBorrowCounts->values(); // Values that represent the number of books borrowed by each user
        $borrowPercentages = $userBorrowCounts->map(function ($count) use ($totalBorrowedBooks) {
            return round(($count / $totalBorrowedBooks) * 100, 2); // Percentage of total borrowed books per user
        });
        
        return view('librarian.tracking', compact('borrows', 'userNames', 'borrowCounts', 'borrowPercentages'));
    }
    
    
    public function manageBooks()
    {
        $books = Book::all();
        return view('librarian.books.index', compact('books'));
    }

    public function createBook()
    {
        return view('librarian.books.create');
    }

    public function storeBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'copies_available' => 'required|integer|min:1',
        ]);

        $book = new Book();
        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->copies_available = $validated['copies_available'];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $book->image = $imagePath;
        }

        $book->save();

        return redirect()->route('librarian.books.index');
    }

    public function editBook(Book $book)
    {
        return view('librarian.books.edit', compact('book'));
    }

    public function updateBook(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'copies_available' => 'required|integer|min:1',
        ]);

        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->copies_available = $validated['copies_available'];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $book->image = $imagePath;
        }

        $book->save();

        return redirect()->route('librarian.books.index');
    }

    public function viewReports()
    {
        $bookStatusLabels = ['Available', 'Borrowed'];
        $bookStatusData = [
            Book::where('status', 'available')->count(),
            Book::where('status', 'borrowed')->count()
        ];

        return view('librarian.reports.index', compact('bookStatusLabels', 'bookStatusData'));
    }

    public function showUsers()
    {
        $users = User::where('role', 'user')->get();
        return view('librarian.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('librarian.users.create');
    }

    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
        ]);

        return redirect()->route('librarian.users.index')->with('success', 'User created successfully!');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('librarian.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->update($validatedData);

        return redirect()->route('librarian.users.index')->with('success', 'User updated successfully!');
    }
}
