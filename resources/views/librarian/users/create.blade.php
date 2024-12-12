<!-- resources/views/librarian/users/create.blade.php -->

@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4 text-center text-primary">Add New User</h1>

    <form action="{{ route('librarian.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone (optional)</label>
            <input type="text" class="form-control" name="phone" id="phone">
        </div>

        <div class="form-group">
            <label for="address">Address (optional)</label>
            <input type="text" class="form-control" name="address" id="address">
        </div>

        <button type="submit" class="btn btn-primary">Save User</button>
    </form>
</div>
@endsection
