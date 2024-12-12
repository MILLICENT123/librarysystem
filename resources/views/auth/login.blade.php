@extends('layout.master')

@section('title', 'Login')

@section('content')
<div class="container-fluid bg-light vh-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-4">
            <div class="p-4 bg-light rounded shadow-lg">
                <h3 class="text-center mb-4">Welcome Back!</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-dark btn-lg w-100">Login</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('register') }}">Don't have an account? Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
