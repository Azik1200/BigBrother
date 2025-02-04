@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Список групп</h1>

        <a href="{{ route('group.create') }}" class="btn btn-primary mb-4">
            <i class="bi bi-plus-circle me-2"></i>Создать группу
        </a>

        <ul class="list-group">
            @foreach ($groups as $group)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{-- Ссылка на страницу группы --}}
                    <a href="{{ route('group.show', $group->id) }}">
                        <strong>{{ $group->name }}</strong>
                    </a>

                    {{-- Кнопка Delete --}}
                    <form action="{{ route('group.delete', $group->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту группу?');">
                        @csrf
                        @method('PUT')

                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Удалить
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
