@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Title -->
                <div class="text-center mb-5">
                    <h1 class="fw-bold text-primary">
                        <i class="bi bi-upload me-2"></i> Upload NLD File
                    </h1>
                    <p class="text-muted">Please select an Excel file (.xlsx or .xls) to upload and create NLD records.</p>
                </div>

                <!-- Card Form -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">

                        <form action="{{ route('nld.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- File Input -->
                            <div class="mb-4">
                                <label for="nld_file" class="form-label fw-semibold">Select Excel NLD file</label>
                                <input
                                    type="file"
                                    name="nld_file"
                                    id="nld_file"
                                    class="form-control @error('nld_file') is-invalid @enderror"
                                    accept=".xlsx, .xls"
                                    required
                                >
                                @error('nld_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted">Accepted formats: .xlsx, .xls</div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('nld.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Back
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-upload me-1"></i> Upload & Create
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
