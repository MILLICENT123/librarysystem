<!-- resources/views/librarian/users/index.blade.php -->

@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4 text-center text-primary">Manage Users</h1>

    {{-- Button to add a new user --}}
    <div class="text-right mb-4">
        <a href="{{ route('librarian.users.create') }}" class="btn btn-primary">Add New User</a>
    </div>

    {{-- Users Table --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->address }}</td>
                <td>
                    <a href="{{ route('librarian.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
