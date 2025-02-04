@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Создать группу</h1>

        <form action="{{ route('group.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Название группы</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Название группы" required>
            </div>

            <button type="submit" class="btn btn-success">Создать</button>
        </form>
    </div>
@endsection
