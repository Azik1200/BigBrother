<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Логотип или название приложения -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">BigBrother</a>

        <!-- Кнопка для открытия меню в мобильной версии -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Ссылки на основные секции -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        Main
                    </a>
                </li>
                <!--
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tasks') ? 'active' : '' }}" href="{{ route('tasks') }}">
                        Tasks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('group.list') ? 'active' : '' }}" href="{{ route('group.list') }}">
                        Groups
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        Profile
                    </a>
                </li>
-->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('nld') ? 'active' : '' }}" href="{{ route('nld') }}">
                        NLD
                    </a>
                </li>
                <!-- Проверка условий: доп пункты меню -->
                <!--
                @if (

                    auth()->user()->groups->contains('name', 'ON') ||
                    auth()->user()->roles->pluck('name')->contains('director') ||
                    auth()->user()->roles->pluck('name')->contains('admin')

                )
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('followup') ? 'active' : '' }}" href="{{ route('followup') }}">
                            FollowUp
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('jira') ? 'active' : '' }}" href="{}">
                            Jira
                        </a>
                    </li>
                @endif
                -->
            </ul>

            <!-- Кнопка выхода -->
            <div class="d-flex align-items-center gap-2">
                @if(auth()->user() && auth()->user()->roles->pluck('name')->contains('admin'))
                    <a href="{{ route('admin') }}" class="btn btn-outline-light">
                        <i class="bi bi-tools"></i> Admin panel
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
