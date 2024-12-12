@extends('layout.master')

@section('title', 'My Profile')

@section('content')
    <div class="container">
        <h1>My Profile</h1>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image</label>
                <input type="file" name="profile_image" id="profile_image" class="form-control">

                @php
                    $profileImageUrl = $user->profile_image 
                        ? asset( $user->profile_image) 
                        : asset('images/default-profile.png');
                @endphp

                <img src="{{ $profileImageUrl }}" alt="Profile Image" class="mt-2" width="100">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
@endsection
