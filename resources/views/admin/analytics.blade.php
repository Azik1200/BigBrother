@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
    <div class="container my-5">
        <h1 class="fw-bold mb-4"><i class="bi bi-bar-chart-line-fill me-2"></i> Analytics Dashboard</h1>

        <div class="row g-4">
            <!-- Total NLD -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="bi bi-file-earmark-text me-2"></i> Total NLD Records
                        </h5>
                        <h2 class="fw-bold">{{ $total }}</h2>
                    </div>
                </div>
            </div>

            <!-- Completed NLD -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="bi bi-check-circle me-2"></i> Completed NLDs
                        </h5>
                        <h2 class="fw-bold">{{ $done }}</h2>
                    </div>
                </div>
            </div>

            <!-- In Progress -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-warning">
                            <i class="bi bi-clock-history me-2"></i> In Progress
                        </h5>
                        <h2 class="fw-bold">{{ $inProgress }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <!-- By Issue Type -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-tags me-2"></i> Breakdown by Issue Type</h5>
                        <ul class="list-group">
                            @forelse($byType as $type => $count)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ $type ?: 'Undefined' }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">No data</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- By Group -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-people me-2"></i> Breakdown by Group</h5>
                        <ul class="list-group">
                            @forelse($byGroup as $groupName => $count)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ $groupName }}</span>
                                    <span class="badge bg-info rounded-pill">{{ $count }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">No data</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
