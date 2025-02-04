@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-xl font-bold mb-4">Редактировать задачу</h1>

        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block font-medium">Название задачи</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    class="border border-gray-300 rounded-md w-full p-2"
                    value="{{ old('title', $task->title) }}"
                    required>
                @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block font-medium">Описание задачи</label>
                <textarea
                    name="description"
                    id="description"
                    class="border border-gray-300 rounded-md w-full p-2"
                    rows="5">{{ old('description', $task->description) }}</textarea>
                @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="is_completed" class="inline-flex items-center">
                    <input
                        type="checkbox"
                        name="is_completed"
                        id="is_completed"
                        class="mr-2"
                        value="1"
                        {{ $task->is_completed ? 'checked' : '' }}>
                    Завершена
                </label>
            </div>

            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Обновить задачу
            </button>
        </form>
    </div>
@endsection
