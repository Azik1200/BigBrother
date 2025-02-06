@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">Список задач</h1>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Создать задачу
            </a>
        </div>

        <!-- Назначенные мне -->
        <div class="mb-5">
            <h2 class="h4 text-success mb-3"><i class="bi bi-person-fill me-2"></i>Назначенные мне</h2>

            @if($assignedTasks->count())
                <div class="list-group">
                    @foreach($assignedTasks as $task)
                        <div class="list-group-item py-3">
                            <h5 class="mb-1">{{ $task->title }}</h5>
                            <p class="mb-1 text-muted">{{ $task->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i> Назначено: {{ $task->created_at->format('d.m.Y H:i') }} |
                                    <i class="bi bi-calendar-event me-1"></i> Дедлайн: {{ $task->due_date }}
                                </small>
                                <div>
                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-info btn-sm me-2">
                                        Подробнее
                                    </a>
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-warning btn-sm me-2">
                                        Редактировать
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">У вас пока нет назначенных задач.</p>
            @endif
        </div>

        <!-- Созданы мной -->
        <div class="mb-5">
            <h2 class="h4 text-primary mb-3"><i class="bi bi-pencil-square me-2"></i>Созданные мной</h2>

            @if($createdTasks->count())
                <div class="list-group">
                    @foreach($createdTasks as $task)
                        <div class="list-group-item py-3">
                            <h5 class="mb-1">{{ $task->title }}</h5>
                            <p class="mb-1 text-muted">{{ $task->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i> Назначено: {{ $task->created_at->format('d.m.Y H:i') }} |
                                    <i class="bi bi-calendar-event me-1"></i> Дедлайн: {{ $task->due_date }}
                                </small>
                                <div>
                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-info btn-sm me-2">
                                        Подробнее
                                    </a>
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-warning btn-sm me-2">
                                        Редактировать
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Вы ещё не создали задач.</p>
            @endif
        </div>

        <!-- Без исполнителей -->
        <div>
            <h2 class="h4 text-warning mb-3"><i class="bi bi-person-dash-fill me-2"></i>Задачи без исполнителя</h2>

            @if($unassignedTasks->count())
                <div class="list-group">
                    @foreach($unassignedTasks as $task)
                        <div class="list-group-item py-3">
                            <h5 class="mb-1">{{ $task->title }}</h5>
                            <p class="mb-1 text-muted">{{ $task->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i> Назначено: {{ $task->created_at->format('d.m.Y H:i') }} |
                                    <i class="bi bi-calendar-event me-1"></i> Дедлайн: {{ $task->due_date }}
                                </small>
                                <div>
                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-info btn-sm me-2">
                                        Подробнее
                                    </a>
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-warning btn-sm me-2">
                                        Редактировать
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Нет ни одной задачи без исполнителя.</p>
            @endif
        </div>
    </div>
@endsection
