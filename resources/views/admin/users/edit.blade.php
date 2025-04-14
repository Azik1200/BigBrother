@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">

                <div class="text-center mb-4">
                    <h1 class="fw-bold text-primary">
                        <i class="bi bi-pencil me-2"></i>Edit user
                    </h1>
                    <p class="text-muted">Update user data</p>
                </div>

                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <form action="{{ route('admin.user.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Имя -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}"
                                    required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Фамилия -->
                            <div class="mb-4">
                                <label for="last_name" class="form-label fw-semibold">Surname</label>
                                <input
                                    type="text"
                                    name="last_name"
                                    id="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name', $user->surname) }}"
                                    required>
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Логин -->
                            <div class="mb-4">
                                <label for="username" class="form-label fw-semibold">Login</label>
                                <input
                                    type="text"
                                    name="username"
                                    id="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username', $user->username) }}"
                                    required>
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}"
                                    required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Телефон -->
                            <div class="mb-4">
                                <label for="phone" class="form-label fw-semibold">Phone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    id="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}"
                                    required>
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Пароль -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Оставьте пустым, чтобы не изменять пароль">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Повтор пароля -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirm password</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    placeholder="Повторите пароль">
                            </div>

                            <!-- Роли -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Roles</label>
                                <div>
                                    @foreach($roles as $role)
                                        <div class="form-check">
                                            <input
                                                type="checkbox"
                                                name="roles[]"
                                                id="role_{{ $role->id }}"
                                                value="{{ $role->id }}"
                                                class="form-check-input @error('roles') is-invalid @enderror"
                                                {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                            <label for="role_{{ $role->id }}" class="form-check-label">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    @error('roles')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Groups</label>
                                <div>
                                    @foreach($groups as $group)
                                        <div class="form-check">
                                            <input
                                                type="checkbox"
                                                name="groups[]"
                                                id="group_{{ $group->id }}"
                                                value="{{ $group->id }}"
                                                class="form-check-input"
                                                {{ $user->groups->contains($group->id) ? 'checked' : '' }}>
                                            <label for="group_{{ $group->id }}" class="form-check-label">
                                                {{ $group->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
