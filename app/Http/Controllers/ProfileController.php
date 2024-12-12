<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Import Storage facade


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }
  
        public function edit()
        {
            $user = Auth::user(); // Get the currently authenticated user
            return view('profile.edit', compact('user')); // Pass the user to the view
        }

        public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user')); // Make sure you have a `profile/show.blade.php` view.
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }
    
        // public function update(Request $request)
        // {
        //     $user = auth()->user();
        
        //     // Validate request
        //     $request->validate([
        //         'name' => 'required|string|max:255',
        //         'email' => 'required|email|max:255',
        //         'profile_image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        //     ]);
        
        //     // Update name and email
        //     $user->name = $request->name;
        //     $user->email = $request->email;
        
        //     // Handle profile image upload
        //     if ($request->hasFile('profile_image')) {
        //         $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        //         $user->profile_image = $imagePath;
        //     }
        
        //     $user->save();
        
        //     return redirect()->route('profile')->with('success', 'Profile updated successfully!');
        // }
        
    }
    