<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBooks = Book::count();
        $availableBooks = Book::sum('copies_available');
        $borrowedBooks = \DB::table('borrows')->whereNull('returned_at')->count();
        $totalBorrowedBooks = \DB::table('borrows')->count();
    
        return view('admin.dashboard', compact('totalBooks', 'availableBooks', 'borrowedBooks', 'totalBorrowedBooks'));
    }
    

    public function notifications()
    {
        // Fetch notifications for the admin
        $notifications = auth()->user()->notifications; // Assuming notifications are tied to the User model

        return view('admin.notifications', compact('notifications'));
    }
    
    public function statistics()
    {
        $currentMonth = Carbon::now()->month;
        $months = [];
        $availableBooks = [];

        // Get the trend of available books for the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('F');
            $months[] = $month;

            // Count the available books for each month
            $availableBooks[] = Book::whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                ->where('status', 'available')
                ->count();
        }

        // Debugging: Check if the data is correct
        // dd($months, $availableBooks);

        return view('admin.statistics', compact('months', 'availableBooks'));
    }
}
