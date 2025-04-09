@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">Список NLD</h1>
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('nld.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Создать NLD
                </a>
            @endif
        </div>

        <div class="list-group">
            @if($nlds->count())
                @foreach($nlds as $nld)
                    @if(auth()->check() && !auth()->user()->isAdmin() && auth()->user()->groups[0]->id == $nld->group_id || auth()->check() && auth()->user()->isAdmin())
                        <div class="list-group-item py-3">
                            <h5 class="mb-1">{{ $nld->issue_key }}</h5>
                            <p class="mb-1 text-muted">{{ Str::limit($nld->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-person-fill me-1"></i> Репортер: {{ $nld->reporter_name }} |
                                    <i class="bi bi-type me-1"></i> Тип: {{ $nld->issue_type }} |
                                    <i class="bi bi-calendar-check me-1"></i> Обновлено:
                                    @if ($nld->updated)
                                        {{ \Carbon\Carbon::parse($nld->updated)->format('d.m.Y') }}
                                    @else
                                        Нет данных
                                    @endif
                                </small>
                                <div>
                                    <a href="{{ route('nld.show', $nld) }}" class="btn btn-outline-info btn-sm me-2">
                                        Подробнее
                                    </a>
                                    <form action="{{ route('nld.done', $nld) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-success btn-sm">Закончено</button>
                                    </form>
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <a href="{{ route('nld.edit', $nld) }}" class="btn btn-outline-warning btn-sm me-2">
                                            Редактировать
                                        </a>
                                        <form action="" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <p class="text-muted">Нет ни одной записи NLD.</p>
            @endif
        </div>
    </div>
@endsection
