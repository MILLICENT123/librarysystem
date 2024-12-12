<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 


class BookController extends Controller
{
   
    public function index(Request $request)
{
    $search = $request->input('search');
    $category = $request->input('category');

    $books = Book::with('categories')
        ->when($search, function ($query, $search) {
            $query->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        })
        ->when($category, function ($query, $category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category); // Specify 'categories.id' to avoid ambiguity
            });
        })
        ->paginate(10);

    $categories = Category::all();
    return view('books.index', compact('books', 'categories'));
}


    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'copies_available' => 'required|integer|min:1',
            'status' => 'required|in:available,borrowed',
            'categories' => 'nullable|array',
        ]);

        $imagePath = $request->file('image')?->store('books', 'public');

        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'copies_available' => $validated['copies_available'],
            'status' => $validated['status'],
        ]);

        $book->categories()->sync($validated['categories'] ?? []);

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'copies_available' => 'required|integer|min:1',
            'status' => 'required|in:available,borrowed',
            'categories' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::delete('public/' . $book->image);
            }
            $book->image = $request->file('image')->store('books', 'public');
        }

        $book->update($validated);

        $book->categories()->sync($validated['categories'] ?? []);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }
    public function destroy(Book $book)
    {
        // Delete the image from storage if it exists
        if ($book->image) {
            Storage::delete('public/' . $book->image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully!');
    }

    public function show($id)
    {
        $book = Book::findOrFail($id); // Find the book by ID or throw a 404 error
        return view('books.show', compact('book')); // Return a view with the book data
    }
}



    // Update the specified book (admin only)
    // public function update(Request $request, Book $book)
    // {
    //     // Validation for updating book fields
    //     $validatedData = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'author' => 'required|string|max:255',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'copies_available' => 'required|integer|min:1',
    //         'status' => 'required|in:available,borrowed',
    //     ]);
    //     $book->title = $validatedData['title'];
    //     $book->author = $validatedData['author'];
    //     $book->copies_available = $validatedData['copies_available'];
    //     $book->status = $validatedData['status'];

    //     if ($request->hasFile('image')) {
    //         if ($book->image) {
    //             Storage::delete('public/' . $book->image);
    //         }
    //         $book->image = $request->file('image')->store('books', 'public');
    //     }
    //     $book->save();
    //     return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    // }

    // Remove the specified book (admin only)
   



