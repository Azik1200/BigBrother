@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Create a group</h1>

        <form action="{{ route('group.store') }}" method="POST">
            @csrf

            <!-- Название группы -->
            <div class="mb-3">
                <label for="name" class="form-label">Group name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Group name"
                    value="{{ old('name') }}"
                    required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Руководитель группы -->
            <div class="mb-3">
                <label for="group_leader" class="form-label">Team Leader</label>
                <select
                    name="group_leader"
                    id="group_leader"
                    class="form-control @error('group_leader') is-invalid @enderror"
                    required>
                    <option value="" disabled selected>Select a leader</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('group_leader') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('group_leader')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Кнопка отправки -->
            <button type="submit" class="btn btn-success">Create</button>
        </form>

        <a href="{{ route('group') }}" class="btn btn-secondary mt-4">
            <i class="bi bi-arrow-left-circle me-2"></i>Back to the list of groups
        </a>
    </div>
@endsection
