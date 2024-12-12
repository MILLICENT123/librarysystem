<!-- resources/views/wishlist/index.blade.php -->

@extends('layout.master')

@section('title', 'My Wishlist')

@section('content')
<div class="container">
    <h3 class="my-4">My Wishlist</h3>
    <ul class="list-group">
        @foreach ($wishlistItems as $item)
            <li class="list-group-item">
                <a href="{{ route('books.show', $item->book->id) }}">
                    {{ $item->book->title }} <!-- Assuming the Book model has a 'title' field -->
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
