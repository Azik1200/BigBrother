@extends('layouts.admin')

@section('title', 'Информация о пользователе')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Информация о пользователе: {{ $user->name }}</h1>

        <a href="{{ route('admin.users') }}" class="btn btn-secondary mb-3">Вернуться к списку пользователей</a>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Основная информация</h5>

                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Имя:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Роль:</strong> @forelse ($user->roles as $role)
                        <span class=>{{ $role->name }}</span>
                    @empty
                        <span class="text-muted">Роль не назначена</span>
                    @endforelse
                </p>
                <p><strong>Группы:</strong>
                    @forelse ($user->groups as $group)
                        <span>{{ $group->name }}</span>
                    @empty
                        <span class="text-muted">Группы не назначены</span>
                    @endforelse
                </p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Группы</h5>

                @forelse ($groups as $group)
                    <span class="badge bg-primary">{{ $group->name }}</span>
                @empty
                    <p>Пользователь не состоит ни в одной группе</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
