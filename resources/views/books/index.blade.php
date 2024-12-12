@extends('layout.master')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Books Collection</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('books.index') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search by title or description..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <!-- Books Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($books as $book)
            <div class="col">
                <div class="card shadow-sm h-100">
                    <!-- Book Cover -->
                    <img src="{{ $book->image ? asset($book->image) : 'https://via.placeholder.com/200' }}" 
                         class="card-img-top" 
                         alt="{{ $book->title }}" 
                         style="height: 250px; object-fit: cover;">

                    <!-- Book Content -->
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-truncate">{{ $book->title }}</h5>
                        <p class="text-muted mb-1">
                            <strong>Author:</strong> {{ $book->author }}
                        </p>
                        <p class="text-muted mb-1">
                            <strong>Categories:</strong> {{ $book->categories->pluck('name')->join(', ') ?: 'None' }}
                        </p>
                        <p class="text-muted mb-1">
                            <strong>Copies:</strong> {{ $book->copies_available }}
                        </p>
                        <p class="card-text mb-3">
                            <span class="short-description" id="short-description-{{ $book->id }}">
                                {{ Str::limit($book->description, 20, '') }}
                                <a href="#" class="text-primary read-more-link" data-id="{{ $book->id }}">Read More</a>
                            </span>
                            <span class="full-description d-none" id="full-description-{{ $book->id }}">
                                {{ $book->description }}
                                <a href="#" class="text-primary read-less-link" data-id="{{ $book->id }}">Show Less</a>
                            </span>
                        </p>

                        <!-- Actions -->
                        <div class="mt-auto">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-info btn-sm">View</a>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No books found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $books->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle Read More and Show Less
        document.querySelectorAll('.read-more-link').forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();

                // Get the book ID from the data-id attribute
                const bookId = this.getAttribute('data-id');

                // Toggle visibility of short and full descriptions
                document.getElementById(`short-description-${bookId}`).classList.add('d-none');
                document.getElementById(`full-description-${bookId}`).classList.remove('d-none');
            });
        });

        document.querySelectorAll('.read-less-link').forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();

                // Get the book ID from the data-id attribute
                const bookId = this.getAttribute('data-id');

                // Toggle visibility of short and full descriptions
                document.getElementById(`full-description-${bookId}`).classList.add('d-none');
                document.getElementById(`short-description-${bookId}`).classList.remove('d-none');
            });
        });
    });
</script>
@endpush
