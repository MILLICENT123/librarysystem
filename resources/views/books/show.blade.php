@extends('layout.master')

@section('content')
<div class="container">
    <div class="card my-4">
        <div class="row g-0">
            <!-- Book Image -->
            <div class="col-md-4">
                <img src="{{ $book->image }}" class="card-img-top" alt="{{ $book->title }}" style="height: 200px; object-fit: cover;">
            </div>
            <!-- Book Details -->
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="card-text"><strong>Author:</strong> {{ $book->author }}</p>
                    <p class="card-text"><strong>Status:</strong> {{ ucfirst($book->status) }}</p>
                    <p class="card-text"><strong>Copies Available:</strong> {{ $book->copies_available }}</p>
                    <p class="card-text"><strong>Description:</strong> {{ $book->description }}</p>
                    
                    <!-- Borrow Button -->
                    @if(auth()->check() && auth()->user()->role == 'user')
                        <form action="{{ route('user.borrow', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success" 
                                {{ $book->copies_available <= 0 ? 'disabled' : '' }}>
                                Borrow Book
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('books.index') }}" class="btn btn-primary mt-2">Back to Books</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
