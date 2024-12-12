@extends('layout.master')

@section('title', 'Welcome to Our Library')

@section('content')
<div class="container mt-5 text-center">
    <h1 class="display-4">Welcome to Our Library Management System</h1>
    <p class="lead mt-3">Discover, Borrow, and Manage Books with Ease</p>

    
    <!-- Call-to-Action Section -->
    <div class="mt-5">
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">
            <i class="fas fa-sign-in-alt"></i> Login
        </a>
        <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-user-plus"></i> Register
        </a>
    </div>
    
    <!-- Hero Image Section -->
    <div class="mt-5">
        <img src="{{ asset('images/library1.png') }}" alt="Library Image" class="img-fluid rounded-3 shadow-lg" style="max-width: 90%; height: auto;">
    </div>

    <!-- Features Section -->
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card shadow-lg border-light rounded-3">
                <img src="{{ asset('images/search book.jpg') }}" class="card-img-top" alt="Search Books">
                <div class="card-body">
                    <h5 class="card-title">Search Books</h5>
                    <p class="card-text">Easily search for books.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg border-light rounded-3">
            <video class="card-img-top" autoplay muted loop>
                  <source src="{{ asset('video/borrow1.mp4') }}" type="video/mp4">
            </video>               
             <div class="card-body">
                    <h5 class="card-title">Borrow Books</h5>
                    <p class="card-text">Borrow books effortlessly and keep track of your borrowed books.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg border-light rounded-3">
            <video class="card-img-top" autoplay muted loop>
                  <source src="{{ asset('video/return book.mp4') }}" type="video/mp4">
            </video>                 <div class="card-body">
                    <h5 class="card-title">Return Books</h5>
                    <p class="card-text">Return borrowed books on time and avoid overdue fines.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="mt-5 text-center">
        <h2 class="text-info">About Our Library</h2>
        <p class="lead">Our library offers a vast collection of books across various genres. From fiction to non-fiction, educational resources to research materials, we provide a comprehensive selection of books to help you in your learning journey.</p>
        <img src="{{ asset('images/About library 3.jpg') }}" alt="About Library" class="img-fluid rounded-3 shadow-lg" style="max-width: 30%; height: auto;"> 
        <img src="{{ asset('images/about3.jpg') }}" alt="About Library" class="img-fluid rounded-3 shadow-lg" style="max-width: 20%; height: auto;">
        <img src="{{ asset('images/about4.jpg') }}" alt="About Library" class="img-fluid rounded-3 shadow-lg" style="max-width: 20%; height: auto;">
        <img src="{{ asset('images/about5.jpg') }}" alt="About Library" class="img-fluid rounded-3 shadow-lg" style="max-width: 20%; height: auto;">
        <img src="{{ asset('images/About library.avif') }}" alt="About Library" class="img-fluid rounded-1 shadow-lg" style="max-width: 20%; height: auto;"> 

    </div>
</div>
@endsection
