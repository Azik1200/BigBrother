@extends('layouts.admin')

@section('title', 'Процедуры')

@section('content')
    <div class="container">
        <h1 class="mb-4">Процедуры</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('procedures.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Название процедуры</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Введите название процедуры" required>
            </div>
            <div class="mb-3">
                <label for="group_id" class="form-label">Группа</label>
                <select id="group_id" name="group_id" class="form-control" required>
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Файл процедуры</label>
                <input type="file" id="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Загрузить процедуру</button>
        </form>

        <hr>

        <h2>Список процедур</h2>
        @if ($procedures->isEmpty())
            <p class="text-muted">Нет загруженных процедур.</p>
        @else
            <ul class="list-group">
                @foreach ($procedures as $procedure)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $procedure->name }}</strong>

                            <p class="text-muted mb-0">
                                Группа: {{ $procedure->group->name ?? 'Не указана' }}
                            </p>
                            <p class="text-muted mb-0">
                                <a href="{{ asset('storage/' . $procedure->file_path) }}" target="_blank">
                                    Скачать файл
                                </a>
                            </p>
                        </div>

                        <form action="#" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту процедуру?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
