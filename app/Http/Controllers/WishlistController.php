<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = auth()->user()->wishlistItems;  
        return view('user.wishlist.index', compact('wishlistItems'));
    }
}
