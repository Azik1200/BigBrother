@include('header')

<div class="container my-5">
    <div class="row">
        <!-- Левая колонка -->
        <div class="col-md-4">
            <!-- Информация о профиле -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Profile</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Surname:</strong> {{ $user->surname }}</p>
                </div>
            </div>

            <!-- Информация о группах -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Groups</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($groups as $group)
                            <li class="list-group-item">
                                <i class="bi bi-people-fill text-success me-2"></i> {{ $group->name }}
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No groups</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Правая колонка -->
        <div class="col-md-8">
            <div class="row">
                <!-- Назначенные задачи -->
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">My tasks</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse ($assignedTasks as $task)
                                    <li class="list-group-item d-flex justify-content-between align-items-start flex-column">
                                        <div>
                                            <strong>{{ $task->name }}</strong>
                                        </div>

                                        <div class="text-muted small">
                                            Group: {{ $task->group->name ?? 'Без группы' }} <br>
                                            Creator: {{ $task->creator ? $task->creator->name . ' ' . $task->creator->surname : 'Неизвестно' }} <br>
                                            Completion date: {{ $task->due_date ? $task->due_date : 'Не указан' }}
                                        </div>

                                        <div class="mt-2 d-flex justify-content-between">
                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-outline-primary btn-sm">
                                                Go to task
                                            </a>

                                            <form action="{{ route('tasks.unassign', $task->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm">
                                                    Take off yourself
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">No tasks</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Задачи без исполнителя -->
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Tasks without an executor</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse ($groupTasksNoAssignee as $task)
                                    <li class="list-group-item d-flex justify-content-between align-items-start flex-column">
                                        <div>
                                            <strong>{{ $task->name }}</strong>
                                        </div>

                                        <div class="text-muted small">
                                            Group: {{ $task->group->name ?? 'Без группы' }} <br>
                                            Creator: {{ $task->creator ? $task->creator->name . ' ' . $task->creator->surname : 'Неизвестно' }} <br>
                                            Completion date: {{ $task->due_date ? $task->due_date : 'Не указан' }}
                                        </div>

                                        <div class="mt-2 d-flex justify-content-between">
                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-outline-primary btn-sm">
                                                Go to task
                                            </a>
                                            <form action="{{ route('tasks.assign', $task->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm">
                                                    Take on
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">No tasks</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
