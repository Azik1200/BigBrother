@extends('layouts.app')

@section('content')
<h1>Список задач</h1>

<a href="{{ route('tasks.create') }}" class="btn btn-primary">Создать задачу</a>

@if($tasks->count())
<ul>
    @foreach($tasks as $task)
    <li>
        <strong>{{ $task->title }}</strong>
        <p>{{ $task->description }}</p>
        <a href="{{ route('tasks.edit', $task) }}">Редактировать</a>
        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Удалить</button>
        </form>
    </li>
    @endforeach
</ul>
@else
<p>Задач нет.</p>
@endif
@endsection
