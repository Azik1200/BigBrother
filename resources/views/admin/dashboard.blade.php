@extends('layouts.admin')

@section('title', 'Панель администратора')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Добро пожаловать в панель администратора</h1>

        <!-- Карточки с быстрым доступом -->
        <div class="row">
            <!-- Быстрое меню -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Управление FolloUp</div>
                    <div class="card-body">
                        <h5 class="card-title">Перейти к FolloUp</h5>
                        <p class="card-text">Здесь вы можете управлять FolloUp и просматривать данные из базы.</p>
                        <a href="{{ route('followup') }}" class="btn btn-light">Перейти</a>
                    </div>
                </div>
            </div>

            <!-- Пример другой карточки -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Пользователи</div>
                    <div class="card-body">
                        <h5 class="card-title">Управление пользователями</h5>
                        <p class="card-text">Просмотр, редактирование и управление пользователями.</p>
                        <a href="{{ route('admin.users') }}" class="btn btn-light">Перейти</a>
                    </div>
                </div>
            </div>

            <!-- Аналитика -->
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Аналитика</div>
                    <div class="card-body">
                        <h5 class="card-title">Отчёты и статистика</h5>
                        <p class="card-text">Просматривайте отчёты и аналитические данные.</p>
                        <a href="#" class="btn btn-light">Посмотреть</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
