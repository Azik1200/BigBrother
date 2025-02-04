@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1>Мои группы</h1>

        @if ($groups->isEmpty())
            <p>Вы не являетесь участником ни одной группы.</p>
        @else
            <ul>
                @foreach ($groups as $group)
                    <li>
                        <a href="{{ route('group.show', $group->id) }}">{{ $group->name }}</a>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Кнопка возврата ко всем группам --}}
        <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-4">
            <i class="bi bi-arrow-left-circle me-2"></i>Назад на начальную странцу
        </a>
    </div>
@endsection
