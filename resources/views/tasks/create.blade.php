@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">

                <div class="text-center mb-4">
                    <h1 class="fw-bold text-primary">
                        <i class="bi bi-plus-circle me-2"></i>Создать новую задачу
                    </h1>
                    <p class="text-muted">Заполните форму, чтобы добавить новую задачу в список</p>
                </div>

                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Название задачи -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">Название задачи</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Введите название задачи"
                                    required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Описание задачи -->
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

                            <!-- Группы -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Группы</label>
                                <div>
                                    @foreach($groups as $group)
                                        <div class="form-check mb-3">
                                            <input
                                                type="checkbox"
                                                name="group_ids[]"
                                                id="group_{{ $group->id }}"
                                                value="{{ $group->id }}"
                                                class="form-check-input @error('group_ids') is-invalid @enderror"
                                                {{ collect(old('group_ids'))->contains($group->id) ? 'checked' : '' }}>
                                            <label for="group_{{ $group->id }}" class="form-check-label">
                                                <strong>Группа:</strong> {{ $group->name }}
                                            </label>

                                            <!-- Информация о лидере группы -->
                                            <p class="text-muted ms-4">
                                                <strong>Лидер:</strong>
                                                {{ $group->leader->name ?? 'Не назначен' }}
                                            </p>
                                        </div>
                                    @endforeach

                                    <!-- Обработка ошибок -->
                                    @error('group_ids')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Выбор лидера задачи -->
                            <div class="mb-4">
                                <label for="task_leader" class="form-label fw-semibold">Лидер задачи</label>
                                <select
                                    name="task_leader"
                                    id="task_leader"
                                    class="form-select @error('task_leader') is-invalid @enderror"
                                    required>
                                    <option value="" disabled {{ old('task_leader') ? '' : 'selected' }}>Выберите лидера</option>
                                    @foreach($groups as $group)
                                        @if($group->leader)
                                            <option value="{{ $group->leader->id }}" {{ old('task_leader') == $group->leader->id ? 'selected' : '' }}>
                                                {{ $group->leader->name }} ({{ $group->leader->email }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('task_leader')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Приоритет -->
                            <div class="mb-4">
                                <label for="priority" class="form-label fw-semibold">Приоритет</label>
                                <select
                                    name="priority"
                                    id="priority"
                                    class="form-control @error('priority') is-invalid @enderror"
                                    required>
                                    <option value="" disabled selected>Выберите приоритет</option>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Низкий</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Средний</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Высокий</option>
                                </select>
                                @error('priority')
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
