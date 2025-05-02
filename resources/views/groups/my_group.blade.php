@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="fw-bold text-primary mb-4">
            <i class="bi bi-people-fill me-2"></i> My Groups
        </h1>

        @if ($groups->isEmpty())
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> You are not a member of any groups.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($groups as $group)
                    <div class="col">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title text-dark fw-semibold">
                                    <i class="bi bi-people me-2"></i> {{ $group->name }}
                                </h5>
                                <a href="{{ route('group.list', $group->id) }}" class="btn btn-outline-primary mt-3">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> View Group
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-5">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle me-2"></i> Back to Home Page
            </a>
        </div>
    </div>
@endsection
