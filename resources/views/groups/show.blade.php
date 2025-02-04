@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1>Группа: {{ $group->name }}</h1>

        {{-- Отображение количества участников --}}
        <p class="mt-3">
            <strong>Количество участников:</strong> {{ $membersCount }}
        </p>

        {{-- Список участников --}}
        <h3 class="mt-4">Участники</h3>
        @if ($group->members->isEmpty())
            <p>В группе пока нет участников.</p>
        @else
            <ul>
                @foreach ($group->members as $member)
                    <li>
                        {{ $member->name }} ({{ $member->email }})
                        {{-- Форма для удаления участника --}}
                        <form
                            action="{{ route('group.remove_member', ['group' => $group->id, 'user' => $member->id]) }}"
                            method="POST"
                            style="display:inline-block; margin-left: 10px;"
                            onsubmit="return confirm('Вы уверены, что хотите удалить {{ $member->name }} из группы?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Кнопка для добавления участников --}}
        <a href="{{ route('group.add_members', $group->id) }}" class="btn btn-primary mt-4">
            Добавить участников
        </a>

        {{-- Кнопка возврата к списку групп --}}
        <a href="{{ route('group') }}" class="btn btn-secondary mt-4">
            <i class="bi bi-arrow-left-circle me-2"></i>Назад к списку групп
        </a>
    </div>
@endsection
