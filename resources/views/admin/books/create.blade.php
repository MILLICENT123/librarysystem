@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <h1>{{ isset($book) ? 'Edit Book' : 'Add New Book' }}</h1>

        <form action="{{ isset($book) ? route('admin.books.update', $book) : route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($book))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $book->title ?? '') }}" required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $book->author ?? '') }}" required>
                @error('author')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $book->description ?? '') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

<div class="mb-3">
    <label for="categories" class="form-label">Categories</label>
    <div id="categories">
        @foreach($categories as $category)
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    name="categories[]" 
                    id="category-{{ $category->id }}" 
                    value="{{ $category->id }}"
                    @if(isset($book) && $book->categories->contains($category->id)) checked @endif
                >
                <label class="form-check-label" for="category-{{ $category->id }}">
                    {{ $category->name }}
                </label>
            </div>
        @endforeach
    </div>
    @error('categories')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


            <div class="mb-3">
                <label for="image" class="form-label">Cover Image</label>
                <input type="file" name="image" id="image" class="form-control">
                @if(isset($book) && $book->image)
                    <small class="text-muted">Current Image: <a href="{{ asset('storage/' . $book->image) }}" target="_blank">View</a></small>
                @endif
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="copies_available" class="form-label">Copies Available</label>
                <input type="number" name="copies_available" id="copies_available" class="form-control" value="{{ old('copies_available', $book->copies_available ?? 1) }}" required min="1">
                @error('copies_available')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="available" {{ old('status', $book->status ?? '') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="borrowed" {{ old('status', $book->status ?? '') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">{{ isset($book) ? 'Update Book' : 'Save Book' }}</button>
        </form>
    </div>
@endsection
