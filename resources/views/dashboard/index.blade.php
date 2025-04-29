@include('header')

<div class="container my-5">
    <div class="row g-4">
        <!-- Left Column -->
        <div class="col-lg-4">
            <!-- Profile Information -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-black rounded-top">
                    <h5 class="mb-0">👤 Profile</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Surname:</strong> {{ $user->surname }}</p>
                </div>
            </div>

            <!-- Group Information -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-gradient-success text-black rounded-top">
                    <h5 class="mb-0">🧑‍🤝‍🧑 Groups</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($groups as $group)
                            <li class="list-group-item">
                                <i class="bi bi-people-fill text-success me-2"></i> {{ $group->name }}
                            </li>
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
                <!-- Assigned Tasks -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-gradient-warning text-dark rounded-top">
                            <h5 class="mb-0">✅ My Tasks</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($assignedTasks as $task)
                                    <li class="list-group-item">
                                        <div class="fw-bold">{{ $task->name }}</div>

                                        <div class="small text-muted mb-2">
                                            Group: {{ $task->group->name ?? 'No Group' }} <br>
                                            Creator: {{ $task->creator ? $task->creator->name . ' ' . $task->creator->surname : 'Unknown' }} <br>
                                            Due Date: {{ $task->due_date ?? 'Not specified' }}
                                        </div>

                                        <div class="d-flex gap-2">
                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                            <form action="{{ route('tasks.unassign', $task->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Unassign
                                                </button>
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

                <!-- Tasks without Executor -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-gradient-info text-black rounded-top">
                            <h5 class="mb-0">🕵️‍♂️ Unassigned Tasks</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($groupTasksNoAssignee as $task)
                                    <li class="list-group-item">
                                        <div class="fw-bold">{{ $task->name }}</div>

                                        <div class="small text-muted mb-2">
                                            Group: {{ $task->group->name ?? 'No Group' }} <br>
                                            Creator: {{ $task->creator ? $task->creator->name . ' ' . $task->creator->surname : 'Unknown' }} <br>
                                            Due Date: {{ $task->due_date ?? 'Not specified' }}
                                        </div>

                                        <div class="d-flex gap-2">
                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                            <form action="{{ route('tasks.assign', $task->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    Assign to Me
                                                </button>
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
</div>
