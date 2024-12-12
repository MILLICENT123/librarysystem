@extends('layout.master')

@section('title', 'Admin Notifications')

@section('content')
    <div class="container">
        <h1>Notifications</h1>
        <ul class="list-group">
            @forelse ($notifications as $notification)
                <li class="list-group-item">
                    {{ $notification->data['message'] ?? 'No details available' }}
                </li>
            @empty
                <li class="list-group-item">No notifications found.</li>
            @endforelse
        </ul>
    </div>
@endsection
