@extends('layout.master')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Book: {{ $book->title }}</h1>

    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Cover Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($book->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $book->image) }}" alt="Book Image" style="max-height: 150px;">
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="copies_available" class="form-label">Copies Available</label>
            <input type="number" class="form-control" id="copies_available" name="copies_available" value="{{ old('copies_available', $book->copies_available) }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="available" {{ $book->status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="borrowed" {{ $book->status == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Book</button>
    </form>
</div>
@endsection
