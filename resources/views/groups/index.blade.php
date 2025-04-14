@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">List of groups</h1>

        <a href="{{ route('group.create') }}" class="btn btn-primary mb-4">
            <i class="bi bi-plus-circle me-2"></i>Create a group
        </a>

        <ul class="list-group">
            @foreach ($groups as $group)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{-- Ссылка на страницу группы --}}
                    <a href="{{ route('group.show', $group->id) }}">
                        <strong>{{ $group->name }}</strong>
                    </a>

                    {{-- Кнопка Delete --}}
                    <form action="{{ route('group.delete', $group->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');">
                        @csrf
                        @method('PUT')

                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
