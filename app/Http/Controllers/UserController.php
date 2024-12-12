<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Notification;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch statistics
        $borrowedBooksCount = Borrow::where('user_id', $user->id)->count();
        $wishlistCount = $user->wishlist()->count();
        $overdueBooksCount = Borrow::where('user_id', $user->id)
            ->whereNull('returned_at')
            ->where('due_date', '<', now())
            ->count();

        // Fetch borrowed books
        $borrowedBooks = $user->borrowedBooks()
            ->withPivot('borrowed_at', 'due_date', 'returned_at')
            ->get();

        // Fetch notifications
        $notifications = Notification::where('user_id', $user->id)->latest()->get();

        // Pass all the variables to the view
        return view('user.dashboard', compact(
            'borrowedBooksCount',
            'wishlistCount',
            'overdueBooksCount',
            'borrowedBooks',
            'notifications'
        ));
        
    }
}
