@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1>Добавление участников в группу: {{ $group->name }}</h1>

        {{-- Сообщение об ошибке валидации --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Форма для добавления участников --}}
        <form action="{{ route('group.store_members', $group->id) }}" method="POST">
            @csrf

            {{-- Список пользователей для выбора --}}
            <div class="form-group">
                <label for="user_ids">Выберите участников:</label>
                <select name="user_ids[]" id="user_ids" class="form-control" multiple>
                    @forelse ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @empty
                        <option disabled>Нет доступных пользователей</option>
                    @endforelse
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-3">Добавить участников</button>
        </form>

        {{-- Кнопка возврата к группе --}}
        <a href="{{ route('group.show', $group->id) }}" class="btn btn-secondary mt-4">
            Назад в группу
        </a>
    </div>
@endsection
