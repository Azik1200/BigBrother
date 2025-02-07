@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">{{ $task->title }}</h1>
            <div>
                <a href="{{ route('tasks') }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Назад
                </a>
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-warning">
                    <i class="bi bi-pencil"></i> Редактировать
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-3">Описание</h5>
                <p class="text-muted mb-0">{{ $task->description }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold text-primary mb-3">Статус</h5>
                        <p class="{{ $task->is_completed ? 'text-success' : 'text-danger' }}">
                            {{ $task->is_completed ? 'Завершена' : 'В процессе' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold text-primary mb-3">Даты</h5>
                        <p class="text-muted mb-0"><i class="bi bi-clock me-2"></i>Создано: {{ $task->created_at->format('d.m.Y H:i') }}</p>
                        <p class="text-muted mb-0"><i class="bi bi-calendar-event me-2"></i>Дедлайн: {{ $task->due_date }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Раздел для комментариев --}}
        <div class="card shadow-sm border-0 mt-5">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-3">Комментарии</h5>

                {{-- Список комментариев --}}
                @if ($task->comments->isEmpty())
                    <p class="text-muted">Комментариев пока нет.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($task->comments as $comment)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        <strong>{{ $comment->user->name . ' ' . $comment->user->surname}}</strong>
                                        <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                                    </span>
                                </div>
                                <p class="mb-0">{{ $comment->comment }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif

                {{-- Форма добавления нового комментария --}}
                <hr class="my-4">
                <form action="{{ route('comments.store', $task->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="comment" class="form-label">Добавить комментарий</label>
                        <textarea name="comment" id="comment" rows="3" class="form-control" placeholder="Напишите комментарий..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
