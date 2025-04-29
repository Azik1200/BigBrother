@extends('layouts.admin')

@section('title', 'User Information')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-primary">
                <i class="bi bi-person-lines-fill me-2"></i> User Details: {{ $user->name }}
            </h1>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to Users
            </a>
        </div>

        <!-- Basic Info Card -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-dark text-white fw-semibold">
                <i class="bi bi-person-badge me-1"></i> Basic Information
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Roles:</strong>
                    @forelse ($user->roles as $role)
                        <span class="badge bg-primary me-1">{{ $role->name }}</span>
                    @empty
                        <span class="text-muted">No role assigned</span>
                    @endforelse
                </p>
                <p><strong>Groups:</strong>
                    @forelse ($user->groups as $group)
                        <span class="badge bg-success me-1">{{ $group->name }}</span>
                    @empty
                        <span class="text-muted">No group assigned</span>
                    @endforelse
                </p>
            </div>
        </div>

        <!-- All Available Groups -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-semibold">
                <i class="bi bi-people me-1"></i> Available Groups
            </div>
            <div class="card-body">
                @forelse ($groups as $group)
                    <span class="badge bg-secondary me-1 mb-1">{{ $group->name }}</span>
                @empty
                    <p class="text-muted">No groups available</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
