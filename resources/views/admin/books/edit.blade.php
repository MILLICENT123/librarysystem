@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Book</h1>

        <!-- Form to Edit Book -->
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $book->title) }}" required>
                @error('title')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Author -->
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $book->author) }}" required>
                @error('author')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Cover Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Cover Image</label>
                <input type="file" name="image" id="image" class="form-control">
                @if($book->image)
                    <div class="mt-2">
                        <img src="{{ asset($book->image) }}" alt="Book Image" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                @endif
                @error('image')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Copies Available -->
            <div class="mb-3">
                <label for="copies_available" class="form-label">Copies Available</label>
                <input type="number" name="copies_available" id="copies_available" class="form-control" value="{{ old('copies_available', $book->copies_available) }}" required min="1">
                @error('copies_available')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="borrowed" {{ old('status', $book->status) == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                </select>
                @error('status')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Categories -->
            <div class="mb-3">
                <label class="form-label">Categories</label>
                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    name="categories[]" 
                                    id="category_{{ $category->id }}" 
                                    value="{{ $category->id }}" 
                                    class="form-check-input" 
                                    {{ in_array($category->id, old('categories', $book->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label for="category_{{ $category->id }}" class="form-check-label">
                                    {{ $category->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('categories')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-warning">Update Book</button>
        </form>
    </div>
@endsection
