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

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Группа</label>
                                <div>
                                    @foreach($groups as $group)
                                        <div class="form-check mb-3">
                                            <input
                                                type="radio"
                                                name="group_id"
                                                id="group_{{ $group->id }}"
                                                value="{{ $group->id }}"
                                                class="form-check-input @error('group_id') is-invalid @enderror"
                                                {{ old('group_id') == $group->id ? 'checked' : '' }}
                                                required>
                                            <label for="group_{{ $group->id }}" class="form-check-label">
                                                <strong>Группа:</strong> {{ $group->name }}
                                            </label>
                                            @if($group->leader)
                                                <p class="text-muted ms-4">
                                                    <strong>Лидер:</strong> {{ $group->leader->name }} ({{ $group->leader->email }})
                                                </p>
                                            @else
                                                <p class="text-muted ms-4">
                                                    <strong>Лидер:</strong> Не назначен
                                                </p>
                                            @endif
                                        </div>
                                    @endforeach
                                    @error('group_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="priority" class="form-label fw-semibold">Приоритет</label>
                                <select
                                    name="priority"
                                    id="priority"
                                    class="form-control @error('priority') is-invalid @enderror"
                                    required>
                                    <option value="" disabled {{ old('priority') ? '' : 'selected' }}>Выберите приоритет</option>
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

                            <div class="mb-4">
                                <label for="status" class="form-label fw-semibold">Статус</label>
                                <select
                                    name="status"
                                    id="status"
                                    class="form-control @error('status') is-invalid @enderror"
                                    required>
                                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>Выберите статус</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Ожидание</option>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>В процессе</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Завершено</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="due_date" class="form-label fw-semibold">Дата выполнения</label>
                                <input
                                    type="date"
                                    name="due_date"
                                    id="due_date"
                                    class="form-control @error('due_date') is-invalid @enderror"
                                    value="{{ old('due_date') }}"
                                    required>
                                @error('due_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Назначить пользователей (опционально)</label>
                                <div>
                                    @foreach($users as $user)
                                        <div class="form-check mb-3">
                                            <input
                                                type="checkbox"
                                                name="assigned_users[]"
                                                id="user_{{ $user->id }}"
                                                value="{{ $user->id }}"
                                                class="form-check-input @error('assigned_users') is-invalid @enderror"
                                                {{ collect(old('assigned_users'))->contains($user->id) ? 'checked' : '' }}>
                                            <label for="user_{{ $user->id }}" class="form-check-label">
                                                {{ $user->name }} ({{ $user->email }})
                                            </label>
                                            @if($user->groupLeaderOf)
                                                <span class="badge bg-info ms-2">Лидер группы: {{ $user->groupLeaderOf->name }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                    @error('assigned_users')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="files" class="form-label fw-semibold">Прикрепить файлы (опционально)</label>
                                <input
                                    type="file"
                                    name="files[]"
                                    id="files"
                                    class="form-control @error('files.*') is-invalid @enderror"
                                    multiple>
                                <small class="form-text text-muted">Вы можете прикрепить несколько файлов.</small>
                                @error('files.*')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

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
