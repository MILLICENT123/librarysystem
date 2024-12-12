<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>
    {{-- Navigation Bar --}}
    <nav class="navbar navbar-expand-lg navbar-primary bg-primary">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Topbar for Authenticated Users --}}
    @auth
        @include('layout.topbar')
    @endauth

    <div class="d-flex">
        {{-- Sidebar (for Authenticated Users) --}}
        @auth
            @include('layout.sidebar')
        @endauth

        {{-- Main Content Area --}}
        <div class="flex-grow-1 p-4">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>
    
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; {{ date('Y') }} Library Management System. All rights reserved.</p>
    </footer>
</body>

</html>
