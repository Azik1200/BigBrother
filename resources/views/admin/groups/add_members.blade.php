@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">

                        <h1 class="fw-bold text-primary mb-4">
                            <i class="bi bi-person-plus-fill me-2"></i> Add Members to Group: {{ $group->name }}
                        </h1>

                        {{-- Ошибки валидации --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Форма добавления участников --}}
                        <form action="{{ route('group.store_members', $group->id) }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="user_ids" class="form-label fw-semibold text-secondary">
                                    Select Participants
                                </label>
                                <select name="user_ids[]" id="user_ids" class="form-select" multiple required>
                                    @forelse ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @empty
                                        <option disabled>No users available</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('group.show', $group->id) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Back to Group
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-person-check-fill me-1"></i> Add Participants
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
