@extends('layouts.admin')

@section('title', 'Управление пользователями')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Управление пользователями</h1>

        <!-- Кнопка "Добавить пользователя" -->
        <a href="{{ route('admin.user.create') }}" class="btn btn-success mb-3">Добавить пользователя</a>
        <a href="{{ route('admin') }}" class="btn btn-secondary mb-3">Вернуться на админ панель</a>

        <!-- Таблица пользователей -->
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Группы</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <a href="{{ route('admin.user.show', $user->id) }}">{{ $user->name }}</a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @forelse ($user->roles as $role)
                            <span class="badge bg-info">{{ $role->name }}</span>
                        @empty
                            <span class="text-muted">Роль не назначена</span>
                        @endforelse
                    </td>
                    <td>
                        @foreach ($user->groups ?? [] as $group)
                            <span class="badge bg-primary">{{ $group->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Редактировать</a>
                        <form action="#" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Пользователи отсутствуют</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
