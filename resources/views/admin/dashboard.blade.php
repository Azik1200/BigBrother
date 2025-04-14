@extends('layouts.admin')

@section('title', 'Панель администратора')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Welcome to the admin panel</h1>

        <!-- Карточки с быстрым доступом -->
        <div class="row">
            <!-- Быстрое меню -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">FollowUp Management</div>
                    <div class="card-body">
                        <h5 class="card-title">Go to FollowUp</h5>
                        <p class="card-text">Here you can manage FolloUp and view data from the database.</p>
                        <a href="{{ route('followup') }}" class="btn btn-light">Go to</a>
                    </div>
                </div>
            </div>

            <!-- Пример другой карточки -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Users</div>
                    <div class="card-body">
                        <h5 class="card-title">User Management</h5>
                        <p class="card-text">View, edit and manage users.</p>
                        <a href="{{ route('admin.users') }}" class="btn btn-light">Go to</a>
                    </div>
                </div>
            </div>

            <!-- Аналитика -->
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Analytics</div>
                    <div class="card-body">
                        <h5 class="card-title">Reports and statistics</h5>
                        <p class="card-text">View reports and analytics.</p>
                        <a href="#" class="btn btn-light">Go to</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
