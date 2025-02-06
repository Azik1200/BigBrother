@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">Редактировать задачу</h1>
            <a
                href="{{ route('tasks.show', $task) }}"
                class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Назад
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Название задачи -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Название задачи</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $task->name) }}"
                            placeholder="Введите название задачи"
                            required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Описание задачи -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Описание задачи</label>
                        <textarea
                            name="description"
                            id="description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="5"
                            placeholder="Введите подробности задачи">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Статус завершения -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input
                                type="checkbox"
                                name="is_completed"
                                id="is_completed"
                                class="form-check-input"
                                value="1"
                                {{ $task->is_completed ? 'checked' : '' }}>
                            <label for="is_completed" class="form-check-label fw-semibold">
                                Задача завершена
                            </label>
                        </div>
                    </div>

                    <!-- Кнопки -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Обновить задачу
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
