<!-- resources/views/librarian/books/index.blade.php -->

@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4 text-center text-primary">Manage Books</h1>

    {{-- Button to add a new book --}}
    <div class="text-right mb-4">
        <a href="{{ route('librarian.books.create') }}" class="btn btn-primary">Add New Book</a>
    </div>

    {{-- Books Table --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Author</th>
                <th>Copies Available</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
            <tr>
                <td>
                    @if($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }} cover" style="width: 50px; height: 75px;">
                    @else
                    <img src="{{ asset('images/default-book.jpg') }}" alt="default cover" style="width: 50px; height: 75px;">
                    @endif
                </td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->copies_available }}</td>
                <td>{{ ucfirst($book->status) }}</td>
                <td>
                    <a href="{{ route('librarian.books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    {{-- Delete button can be added here if needed in future --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
