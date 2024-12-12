@extends('layout.master')

@section('title', 'Manage Borrowed Books')

@section('content')
    <h1>Borrowed Books</h1>

    @if($borrowedBooks->isEmpty())
        <p>No books have been borrowed.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Book</th>
                    <th>Borrowed At</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowedBooks as $borrow)
                    <tr>
                        <td>{{ $borrow->user->name }}</td>
                        <td>{{ $borrow->book->title }}</td>
                        <td>{{ $borrow->borrowed_at->format('d M Y') }}</td>
                        <td>{{ $borrow->due_date->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
