@include('header')

<div class="container my-5">
    <div class="row">
        <!-- Левая колонка -->
        <div class="col-md-4">
            <!-- Информация о профиле -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Профиль</h5>
                </div>
                <div class="card-body">
                    <p><strong>Имя:</strong> {{ $user->name }}</p>
                    <p><strong>Фамилия:</strong> {{ $user->surname }}</p>
                </div>
            </div>

            <!-- Информация о группах -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Группы</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($groups as $group)
                            <li class="list-group-item">
                                <i class="bi bi-people-fill text-success me-2"></i> {{ $group->name }}
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Нет групп</li>
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
                            <h5 class="mb-0">Назначенные задачи</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse ($assignedTasks as $task)
                                    <li class="list-group-item">
                                        <strong>{{ $task->title }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            Группа: {{ $task->group->name ?? 'Без группы' }}
                                        </small>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">Нет задач</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Задачи без исполнителя -->
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Задачи без исполнителя</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse ($groupTasksNoAssignee as $task)
                                    <li class="list-group-item">
                                        <strong>{{ $task->title }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            Создано: {{ $task->creator->first_name ?? 'Неизвестно' }}
                                        </small>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">Нет задач</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
