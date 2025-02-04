<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Логотип или название приложения -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">Моё приложение</a>

        <!-- Кнопка для открытия меню в мобильной версии -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Ссылки на основные секции -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        Главная
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tasks') ? 'active' : '' }}" href="{{ route('tasks') }}">
                        Задачи
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('groups.list') ? 'active' : '' }}" href="{{ route('group.list') }}">
                        Группы
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        Профиль
                    </a>
                </li>
            </ul>

            <form class="d-flex" action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light" type="submit">
                    <i class="bi bi-box-arrow-right"></i> Выйти
                </button>
            </form>
        </div>
    </div>
</nav>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
