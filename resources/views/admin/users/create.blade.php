@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="text-center mb-4">
                    <h1 class="fw-bold text-success">
                        <i class="bi bi-person-plus-fill me-2"></i> Add New User
                    </h1>
                    <p class="text-muted">Fill out the form to register a new user</p>
                </div>

                <div class="card shadow border-0">
                    <div class="card-body p-4">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Surname -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Surname</label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                       value="{{ old('last_name') }}" required>
                                @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Username</label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                       value="{{ old('username') }}" required>
                                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}" required>
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                       required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <!-- Roles -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Roles</label>
                                <div class="row">
                                    @foreach ($roles as $role)
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}">
                                                <label class="form-check-label" for="role_{{ $role->id }}">
                                                    {{ $role->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Groups -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Groups</label>
                                <div class="row">
                                    @foreach ($groups as $group)
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="groups[]" value="{{ $group->id }}" id="group_{{ $group->id }}">
                                                <label class="form-check-label" for="group_{{ $group->id }}">
                                                    {{ $group->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Back
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-person-plus-fill me-1"></i> Create User
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
