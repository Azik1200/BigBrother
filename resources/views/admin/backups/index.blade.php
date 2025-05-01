@extends('layouts.admin')

@section('title', 'Backups')

@section('content')
    <div class="container my-5">
        <h1 class="fw-bold mb-4"><i class="bi bi-hdd-fill me-2"></i> Database Backups</h1>

        <form action="{{ route('admin.backups.create') }}" method="POST" class="mb-3">
            @csrf
            <button type="submit" class="btn btn-dark">
                <i class="bi bi-plus-circle me-1"></i> Create Backup
            </button>
        </form>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-3">Available Backups</h5>
                <ul class="list-group">
                    @forelse($files as $file)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $file['name'] }}</span>
                            <a href="{{ route('admin.backups.download', $file['name']) }}" class="btn btn-sm btn-outline-primary">
                                Download
                            </a>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No backups found.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
