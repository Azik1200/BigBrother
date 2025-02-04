@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-xl font-bold mb-4">Создать новую задачу</h1>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="title" class="block font-medium">Название задачи</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    class="border border-gray-300 rounded-md w-full p-2"
                    value="{{ old('title') }}"
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
                    rows="5">{{ old('description') }}</textarea>
                @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Создать задачу
            </button>
        </form>
    </div>
@endsection
