<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <i class="bi bi-shield-lock-fill me-1"></i> BigBrother
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navigation Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door me-1"></i> Main
                    </a>
                </li>

                <!-- Tasks -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}"
                       href="{{ route('tasks.index') }}">
                        <i class="bi bi-list-task me-1"></i> Tasks
                    </a>
                </li>

                <!-- Groups -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('group.list') ? 'active' : '' }}"
                       href="{{ route('group.list') }}">
                        <i class="bi bi-people me-1"></i> Groups
                    </a>
                </li>

                <!-- NLD -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('nld.index') ? 'active' : '' }}"
                       href="{{ route('nld.index') }}">
                        <i class="bi bi-journal-check me-1"></i> NLD
                    </a>
                </li>

                <!-- Optional: Future items like Profile -->
                {{--
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="bi bi-person-circle me-1"></i> Profile
                    </a>
                </li>
                --}}
            </ul>

            <!-- Right Side Buttons -->
            <div class="d-flex align-items-center gap-2">
                @if(auth()->user() && auth()->user()->roles->contains('name', 'admin'))
                    <a href="{{ route('admin.index') }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-tools me-1"></i> Admin Panel
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="d-inline mb-0">
                    @csrf
                    <button class="btn btn-outline-light btn-sm" type="submit">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Styles -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
