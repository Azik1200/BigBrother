@extends('layouts.admin')

@section('title', 'Group Management')

@section('content')
    <div class="container my-5">
        <h1 class="fw-bold mb-4"><i class="bi bi-diagram-3-fill me-2"></i> Group Management</h1>

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.groups.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Create Group
            </a>
        </div>

        @if ($groups->isEmpty())
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-circle me-2"></i> No groups found.
            </div>
        @else
            <div class="list-group shadow-sm">
                @foreach ($groups as $group)
                    <div class="list-group-item py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">
                                <a href="{{ route('admin.groups.show', $group->id) }}" class="text-decoration-none">
                                    <i class="bi bi-people-fill me-1"></i>{{ $group->name }}
                                </a>
                            </h5>
                            <small class="text-muted">Leader: {{ $group->leader->name ?? 'N/A' }}</small>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.groups.show', $group->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i> View
                            </a>
                            <form action="{{ route('admin.groups.delete', $group->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this group?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
