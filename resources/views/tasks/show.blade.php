@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-xl font-bold mb-4">{{ $task->title }}</h1>

        <div class="mb-4">
            <p class="text-gray-700 font-medium">Описание:</p>
            <p>{{ $task->description }}</p>
        </div>

        <div class="mb-4">
            <p class="text-gray-700 font-medium">Статус:</p>
            <p class="{{ $task->is_completed ? 'text-green-600' : 'text-red-600' }}">
                {{ $task->is_completed ? 'Завершена' : 'В процессе' }}
            </p>
        </div>

        <a
            href="{{ route('tasks.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Назад
        </a>
        <a
            href="{{ route('tasks.edit', $task) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Редактировать
        </a>
    </div>
@endsection
