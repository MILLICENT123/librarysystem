@extends('layout.master')

@section('title', 'My Borrowed Books')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">My Borrowed Books</h1>

    @if($borrowedBooks->isEmpty())
        <div class="alert alert-info">
            <p>You haven't borrowed any books yet.</p>
        </div>
    @else
        <div class="row">
            @foreach($borrowedBooks as $borrow)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <!-- Book Image -->
                        <img src="{{ $borrow->book->image ? asset($borrow->book->image) : 'https://via.placeholder.com/300x200' }}" 
                             class="card-img-top" 
                             alt="{{ $borrow->book->title }}" 
                             style="height: 200px; object-fit: cover;">
                        
                        <div class="card-body">
                            <!-- Book Title -->
                            <h5 class="card-title text-truncate">{{ $borrow->book->title }}</h5>

                            <!-- Borrowed Date -->
                            <p class="card-text text-muted">
                                <strong>Borrowed On:</strong> {{ \Carbon\Carbon::parse($borrow->borrowed_at)->format('d M Y') }}
                            </p>

                            <!-- Book Status -->
                            <p class="card-text">
                                <strong>Status:</strong> {{ ucfirst($borrow->book->status) }}
                            </p>

                            <!-- Copies Available -->
                            <p class="card-text">
                                <strong>Copies Available:</strong> {{ $borrow->book->copies_available }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('books.show', $borrow->book->id) }}" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                                @if($borrow->book->copies_available <= 0)
                                    <button class="btn btn-danger btn-sm" disabled>Unavailable</button>
                                @else
                                    <button class="btn btn-success btn-sm">Re-Borrow</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
