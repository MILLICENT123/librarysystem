<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">Library System</a>

        <!-- Toggler for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible Content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Common Links for All Users -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.index') }}">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('books.index') }}">Books</a>
                </li>

                @if (auth()->check()) 
                    <!-- Role-Specific Links -->
                    @if (auth()->user()->role === 'admin')
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.notifications') }}">Notifications</a>
                        </li>
                    @elseif (auth()->user()->role === 'librarian')
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('librarian.tracking') }}">Track Borrowed Books</a>
                        </li>
                    @elseif (auth()->user()->role === 'user')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.borrow.index') }}">My Borrowed Books</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.wishlist') }}">Wishlist</a>
                        </li>
                    @endif
                @endif

                <!-- Logout Link -->
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
