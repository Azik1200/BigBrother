@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <!-- Заголовок -->
                <div class="text-center mb-4">
                    <h1 class="fw-bold text-primary">
                        <i class="bi bi-plus-circle me-2"></i>Создать новую задачу
                    </h1>
                    <p class="text-muted">Заполните форму, чтобы добавить новую задачу в список</p>
                </div>

                <!-- Карточка с формой -->
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <form action="{{ route('tasks.store') }}" method="POST">
                            @csrf

                            <!-- Поле: Название задачи -->
                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">Название задачи</label>
                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}"
                                    placeholder="Введите название задачи"
                                    required>
                                @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Поле: Описание задачи -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">Описание задачи</label>
                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Добавьте описание задачи"
                                    rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Кнопки действий -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('tasks') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Назад
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Создать задачу
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
