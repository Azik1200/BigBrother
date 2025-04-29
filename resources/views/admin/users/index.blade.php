@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-primary">
                <i class="bi bi-people-fill me-2"></i> User Management
            </h1>
            <div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-success me-2">
                    <i class="bi bi-person-plus-fill me-1"></i> Add User
                </a>
                <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Admin Panel
                </a>
            </div>
        </div>

        <!-- User Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Groups</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-decoration-none fw-semibold">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @forelse ($user->roles as $role)
                                    <span class="badge bg-info text-dark me-1">{{ $role->name }}</span>
                                @empty
                                    <span class="text-muted">No Role</span>
                                @endforelse
                            </td>
                            <td>
                                @forelse ($user->groups as $group)
                                    <span class="badge bg-primary me-1">{{ $group->name }}</span>
                                @empty
                                    <span class="text-muted">No Group</span>
                                @endforelse
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                <form action="#" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash-fill"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">There are no users yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
