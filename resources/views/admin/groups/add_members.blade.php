@extends('layouts.admin')

@section('title', 'Add Members to Group')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white rounded-top">
                        <h4 class="mb-0">
                            <i class="bi bi-person-plus-fill me-2"></i> Add Members to Group: <strong>{{ $group->name }}</strong>
                        </h4>
                    </div>

                    <div class="card-body p-5">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h6 class="fw-bold">Validation Errors:</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.groups.addMembers', $group->id) }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="user_ids" class="form-label fw-semibold text-secondary">
                                    Select Participants
                                </label>
                                <select name="user_ids[]" id="user_ids" class="form-select shadow-sm" size="8" multiple required>
                                    @forelse ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }} — {{ $user->email }}
                                        </option>
                                    @empty
                                        <option disabled>No available users to add</option>
                                    @endforelse
                                </select>
                                <small class="form-text text-muted mt-2">Hold <kbd>Ctrl</kbd> (or <kbd>Cmd</kbd> on Mac) to select multiple users.</small>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.groups.show', $group->id) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Group
                                </a>

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle-fill me-1"></i> Add Members
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
