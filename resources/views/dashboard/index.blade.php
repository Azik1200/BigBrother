@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient bg-primary text-white rounded-top">
                        <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i> Profile</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Surname:</strong> {{ $user->surname }}</p>
                    </div>
                    <div class="text-end px-3 pb-3">
                        <button class="btn btn-outline-light bg-dark" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bi bi-key-fill me-1"></i> Change Password
                        </button>
                    </div>
                </div>

                <!-- Group Card -->
                <div class="card mt-4 border-0 shadow-sm">
                    <div class="card-header bg-gradient bg-success text-white rounded-top">
                        <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i> Groups</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse ($groups as $group)
                                <li class="list-group-item">{{ $group->name }}</li>
                            @empty
                                <li class="list-group-item text-muted">No groups available</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-8">
                <div class="row g-4">
                    <!-- My Tasks -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-warning text-dark rounded-top">
                                <h5 class="mb-0"><i class="bi bi-check2-square me-1"></i> My Tasks</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    @forelse ($assignedTasks as $task)
                                        <li class="list-group-item">
                                            <div class="fw-bold">{{ $task->name }}</div>
                                            <div class="small text-muted mb-2">
                                                Group: {{ $task->group->name ?? 'No Group' }}<br>
                                                Creator: {{ $task->creator->name ?? 'Unknown' }}<br>
                                                Due: {{ $task->due_date ?? 'N/A' }}
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                <form action="{{ route('tasks.unassign', $task->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Unassign</button>
                                                </form>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-muted">No assigned tasks</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Unassigned Tasks -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-info text-white rounded-top">
                                <h5 class="mb-0"><i class="bi bi-exclamation-circle me-1"></i> Unassigned Tasks</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    @forelse ($groupTasksNoAssignee as $task)
                                        <li class="list-group-item">
                                            <div class="fw-bold">{{ $task->name }}</div>
                                            <div class="small text-muted mb-2">
                                                Group: {{ $task->group->name ?? 'No Group' }}<br>
                                                Creator: {{ $task->creator->name ?? 'Unknown' }}<br>
                                                Due: {{ $task->due_date ?? 'N/A' }}
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                <form action="{{ route('tasks.assign', $task->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success">Assign</button>
                                                </form>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-muted">No unassigned tasks</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow border-0">
                    <form method="POST" action="{{ route('password.change') }}">
                        @csrf
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="changePasswordModalLabel">
                                <i class="bi bi-shield-lock-fill me-1"></i> Change Password
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 py-3">
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

    </div>
@endsection
