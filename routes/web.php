<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BorrowController;

// Public Routes
Route::get('/', function () {
    return view('Homepage'); // Ensure the view exists
})->name('Homepage');

// Route for listing books (accessible to all users)
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Route for viewing a single book (accessible to all authenticated users)
Route::middleware('auth')->get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Redirect to appropriate dashboard based on role
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'librarian' => redirect()->route('librarian.dashboard'),
            'user' => redirect()->route('user.dashboard'),
            default => abort(403, 'Unauthorized access'),
        };
    })->name('dashboard');

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/', [ProfileController::class, 'update'])->name('update');
    });

    // Admin-Specific Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
        Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
        
        // Book Management
        Route::resource('/books', BookController::class);
        
        // Category Management
        Route::resource('/categories', CategoryController::class)->except(['show']);
    });

    // Librarian-Specific Routes
    Route::middleware('role:librarian')->prefix('librarian')->name('librarian.')->group(function () {
        Route::get('/dashboard', [LibrarianController::class, 'dashboard'])->name('dashboard');
        Route::get('/tracking', [LibrarianController::class, 'tracking'])->name('tracking');
        Route::get('/books', [BookController::class, 'index'])->name('books.index');
        Route::get('/borrowed-books', [BorrowController::class, 'index'])->name('borrow.index');
        Route::get('/users', [LibrarianController::class, 'manageUsers'])->name('users.index');
        Route::get('/reports', [LibrarianController::class, 'viewReports'])->name('reports.index');
    });

    // User-Specific Routes
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
        Route::get('/borrowed-books', [BorrowController::class, 'userBorrowedBooks'])->name('borrow.index');
        Route::post('/borrow/{book}', [BorrowController::class, 'borrow'])->name('borrow'); // Borrow Route
    });
});
