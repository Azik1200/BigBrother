@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="text-center mb-4">
                    <h1 class="fw-bold text-primary">
                        <i class="bi bi-upload me-2"></i>Загрузить файл NLD
                    </h1>
                    <p class="text-muted">Выберите файл Excel для загрузки</p>
                </div>

                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <form action="{{ route('nld.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="nld_file" class="form-label fw-semibold">Выберите файл Excel NLD</label>
                                <input
                                    type="file"
                                    name="nld_file"
                                    id="nld_file"
                                    class="form-control @error('nld_file') is-invalid @enderror"
                                    required>
                                @error('nld_file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <small class="form-text text-muted">Допустимые форматы: Excel (xlsx, xls)</small>
                            </div>
<!--
                            <div class="mb-4">
                                <label for="issue_type" class="form-label fw-semibold">Status</label>
                                <select name="issue_type" id="issue_type" class="form-select @error('issue_type') is-invalid @enderror" required>
                                    <option value="" selected disabled>Выберите тип проблемы</option>
                                    <option value="To Do">To Do</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Done">Done</option>
                                </select>
                                @error('issue_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
-->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('nld') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Назад
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload me-1"></i>Загрузить и создать
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
