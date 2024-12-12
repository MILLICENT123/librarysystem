<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $bookId)
    {
        // Validate the request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Create a review for the book
        $review = Review::create([
            'user_id' => auth()->id(),  // Assuming the user is authenticated
            'book_id' => $bookId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review added successfully!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }
}
