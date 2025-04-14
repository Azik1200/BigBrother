@extends('layouts.admin')

@section('title', 'Управление пользователями')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">User Management</h1>

        <!-- Кнопка "Добавить пользователя" -->
        <a href="{{ route('admin.user.create') }}" class="btn btn-success mb-3">Add user</a>
        <a href="{{ route('admin') }}" class="btn btn-secondary mb-3">Return to admin panel</a>

        <!-- Таблица пользователей -->
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Groups</th>
                <th>Actions</th>
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
                            <span class="text-muted">Role not assigned</span>
                        @endforelse
                    </td>
                    <td>
                        @foreach ($user->groups ?? [] as $group)
                            <span class="badge bg-primary">{{ $group->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="#" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">There are no users</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
