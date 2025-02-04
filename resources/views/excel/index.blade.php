@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <h1>Загрузка Excel-файла</h1>
        <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Загрузите Excel-файл</label>
                <input type="file" name="file" class="form-control" id="file" required>
                @error('file')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Загрузить</button>
        </form>
    </div>
@endsection
