@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Список групп</h1>

        <a href="{{ route('group.create') }}" class="btn btn-primary mb-4">
            <i class="bi bi-plus-circle me-2"></i>Создать группу
        </a>

        <ul class="list-group">
            @foreach ($groups as $group)
                <li class="list-group-item">
                    <strong>{{ $group->name }}</strong>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
