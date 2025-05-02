@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">

                        <h1 class="fw-bold text-primary mb-4">
                            <i class="bi bi-people-fill me-2"></i> Create a Group
                        </h1>

                        <form action="{{ route('group.store') }}" method="POST">
                            @csrf

                            <!-- Group Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold text-secondary">Group Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter group name"
                                    value="{{ old('name') }}"
                                    required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Team Leader -->
                            <div class="mb-4">
                                <label for="group_leader" class="form-label fw-semibold text-secondary">Team Leader</label>
                                <select
                                    name="group_leader"
                                    id="group_leader"
                                    class="form-select @error('group_leader') is-invalid @enderror"
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

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('group') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Back
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i> Create Group
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
