@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="fw-bold text-primary mb-4">
            <i class="bi bi-collection me-2"></i> List of Groups
        </h1>

        <div class="mb-4">
            <a href="{{ route('group.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i> Create a Group
            </a>
        </div>

        @if ($groups->isEmpty())
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i> No groups have been created yet.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($groups as $group)
                    <div class="col">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title fw-semibold text-dark">
                                    <i class="bi bi-people-fill me-2"></i> {{ $group->name }}
                                </h5>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{ route('group.show', $group->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> View
                                    </a>
                                    <form action="{{ route('group.delete', $group->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
