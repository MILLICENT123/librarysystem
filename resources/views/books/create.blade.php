@extends('layout.master')

@section('content')
<div class="container">
    <h1 class="my-4">Add New Book</h1>

    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Cover Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <div class="mb-3">
            <label for="copies_available" class="form-label">Copies Available</label>
            <input type="number" class="form-control" id="copies_available" name="copies_available" value="1" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="available">Available</option>
                <option value="borrowed">Borrowed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Book</button>
    </form>
</div>
@endsection
