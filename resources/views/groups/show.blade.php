@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1>Group: {{ $group->name }}</h1>

        {{-- Отображение количества участников --}}
        <p class="mt-3">
            <strong>Number of participants:</strong> {{ $membersCount }}
        </p>

        {{-- Список участников --}}
        <h3 class="mt-4">Participants</h3>
        @if ($group->members->isEmpty())
            <p>There are no members in the group yet.</p>
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
                            onsubmit="return confirm('Are you sure you want to remove {{ $member->name }} from the group?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Кнопка для добавления участников --}}
        <a href="{{ route('group.add_members', $group->id) }}" class="btn btn-primary mt-4">
            Add participants
        </a>

        {{-- Кнопка возврата к списку групп --}}
        <a href="{{ route('group') }}" class="btn btn-secondary mt-4">
            <i class="bi bi-arrow-left-circle me-2"></i>Back to the list of groups
        </a>
    </div>
@endsection
