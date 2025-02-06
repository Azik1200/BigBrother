@extends('layouts.app')

@section('title', 'Скрипты')

@section('content')
    <div class="container">
        <h1 class="mb-4">Скрипты</h1>
        {{-- Уведомления об успешных операциях --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('script.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Название скрипта</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Контент</label>
                <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="group_id" class="form-label">Группа</label>
                <select name="group_id" id="group_id" class="form-control">
                    <option value="" selected>Без группы</option>
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Добавить скрипт</button>
        </form>

        {{-- Список скриптов --}}
        <h2>Список скриптов</h2>
        @if ($scripts->isEmpty())
            <p class="text-muted">Нет скриптов</p>
        @else
            <ul class="list-group">
                @foreach ($scripts as $script)
                    <li class="list-group-item">
                        <h5>{{ $script->name }}</h5>
                        <p>{{ $script->content }}</p>
                        <small class="text-muted">Группа: {{ $script->group->name ?? 'Без группы' }}</small>
                        <br>
                        <small class="text-muted">Автор: {{ $script->author->name ?? 'Неизвестно' }}</small>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
