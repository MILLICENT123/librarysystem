@if (Auth::check())
    <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
        {{-- User Profile Section --}}
        <div class="d-flex align-items-center mb-4">
            <img 
                src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('images/default-user.png') }}" 
                alt="User Image" 
                class="rounded-circle me-2" 
                width="50" 
                height="50"
            >
            <div>
                <strong>{{ Auth::user()->name }}</strong>
                <a href="{{ route('profile.index') }}" class="text-white d-block" style="font-size: 0.9em;">
                    View Profile
                </a>
            </div>
        </div>

        {{-- Navigation Links --}}
        <ul class="list-unstyled">
            @if (Auth::user()->role == 'admin')
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.books.index') }}" class="text-white text-decoration-none">
                        <i class="fas fa-book"></i> Manage Books
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.books.create') }}" class="text-white text-decoration-none">
                        <i class="fas fa-plus-circle"></i> Add Book
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.statistics') }}" class="text-white text-decoration-none">
                        <i class="fas fa-chart-line"></i> Statistics
                    </a>
                </li>
            @elseif (Auth::user()->role == 'librarian')
                <li class="mb-2">
                    <a href="{{ route('librarian.dashboard') }}" class="text-white text-decoration-none">
                        <i class="fas fa-tasks"></i> Librarian Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('librarian.borrow.index') }}" class="text-white text-decoration-none">
                        <i class="fas fa-book-reader"></i> Track Borrowed Books
                    </a>
                </li>
            @elseif (Auth::user()->role == 'user')
                <li class="mb-2">
                    <a href="{{ route('user.dashboard') }}" class="text-white text-decoration-none">
                        <i class="fas fa-home"></i> My Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('user.wishlist') }}" class="text-white text-decoration-none">
                        <i class="fas fa-heart"></i> My Wishlist
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('user.borrow.index') }}" class="text-white text-decoration-none">
                        <i class="fas fa-book-reader"></i> Borrowed Books
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
