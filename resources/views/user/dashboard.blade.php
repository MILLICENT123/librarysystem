@extends('layout.master')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Welcome, {{ auth()->user()->name }}</h1>
    
    {{-- User Stats --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Borrowed Books</h5>
                    <p class="card-text display-4 fw-bold">{{ $borrowedBooksCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Wishlist Items</h5>
                    <p class="card-text display-4 fw-bold">{{ $wishlistCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Notifications</h5>
                    <p class="card-text display-4 fw-bold">{{ $notifications->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Borrowed Books Section --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Borrowed Books</h5>
                    @if($borrowedBooks->isEmpty())
                        <p class="text-muted">You haven't borrowed any books yet.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Book Title</th>
                                    <th>Borrowed Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowedBooks as $index => $borrow)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $borrow->book->title }}</td>
                                    <td>{{ $borrow->borrowed_at->format('d M Y') }}</td>
                                    <td>{{ $borrow->due_date->format('d M Y') }}</td>
                                    <td>
                                        @if($borrow->returned_at)
                                            <span class="badge bg-success">Returned</span>
                                        @elseif($borrow->due_date->isPast())
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            <span class="badge bg-warning">Borrowed</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
