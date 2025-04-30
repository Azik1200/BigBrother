@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
    <div class="container my-5">
        <h1 class="fw-bold mb-4"><i class="bi bi-bar-chart-line-fill me-2"></i> Analytics Dashboard</h1>

        <div class="row g-4">
            <!-- Total NLD -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-dark">
                            <i class="bi bi-database-fill me-2"></i> Total NLD Records
                        </h5>
                        <h2 class="fw-bold">{{ \App\Models\Nld::count() }}</h2>
                    </div>
                </div>
            </div>

            <!-- Total Done NLD -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="bi bi-file-earmark-text me-2"></i> Total Done NLD Records
                        </h5>
                        <h2 class="fw-bold">{{ $total }}</h2>
                    </div>
                </div>
            </div>

            <!-- Completed NLD -->
            <div class="col-md-3">
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
            <div class="col-md-3">
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
            <!-- By Group (All Tasks, not filtered by Done) -->
            <!-- All Tasks by Group (Unfiltered) -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-diagram-3 me-2"></i> All Tasks by Group</h5>
                        <ul class="list-group">
                            @php
                                $allGroupDetails = \App\Models\Nld::with('group')
                                    ->get()
                                    ->groupBy(fn($nld) => $nld->group->name ?? 'No Group');
                            @endphp

                            @forelse($allGroupDetails as $groupName => $tasks)
                                @php $slug = \Illuminate\Support\Str::slug($groupName); @endphp
                                <li class="list-group-item">
                                    <div class="fw-bold mb-2">{{ $groupName }}</div>

                                    <div class="d-flex gap-2 flex-wrap">
                                        <button class="btn btn-outline-secondary btn-sm"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#all-{{ $slug }}"
                                                aria-expanded="false"
                                                aria-controls="all-{{ $slug }}">
                                            📋 {{ $tasks->count() }} Total Tasks
                                        </button>
                                    </div>

                                    <!-- All Tasks Collapse -->
                                    <div class="collapse mt-2" id="all-{{ $slug }}">
                                        <div class="card card-body bg-light border-0">
                                            @forelse ($tasks as $task)
                                                <div class="mb-2">
                                                    <i class="bi bi-dot text-muted me-1"></i>
                                                    <a href="{{ route('nld.show', $task) }}" class="text-decoration-none fw-semibold text-dark">
                                                        {{ $task->issue_key }}
                                                    </a> — {{ $task->summary }}
                                                </div>
                                            @empty
                                                <p class="text-muted mb-0">No tasks found.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">No group data</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <!-- By Group -->
            <!-- Breakdown by Group with collapsible details -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-people me-2"></i> Breakdown by Group</h5>
                        <ul class="list-group">
                            @forelse($groupDetails as $groupName => $data)
                                @php $slug = \Illuminate\Support\Str::slug($groupName); @endphp
                                <li class="list-group-item">
                                    <div class="fw-bold mb-2">{{ $groupName }}</div>

                                    <div class="d-flex gap-2 flex-wrap">
                                        <button class="btn btn-outline-success btn-sm"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#done-{{ $slug }}"
                                                aria-expanded="false"
                                                aria-controls="done-{{ $slug }}">
                                            ✅ {{ $data['done']->count() }} Done
                                        </button>

                                        <button class="btn btn-outline-warning btn-sm"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#progress-{{ $slug }}"
                                                aria-expanded="false"
                                                aria-controls="progress-{{ $slug }}">
                                            ⏳ {{ $data['in_progress']->count() }} In Progress
                                        </button>
                                    </div>

                                    <!-- Done Tasks Collapse -->
                                    <div class="collapse mt-2" id="done-{{ $slug }}">
                                        <div class="card card-body bg-light border-0">
                                            @forelse ($data['done'] as $task)
                                                <div class="mb-2">
                                                    <i class="bi bi-check2-circle text-success me-1"></i>
                                                    <a href="{{ route('nld.show', $task) }}" class="text-decoration-none fw-semibold text-success">
                                                        {{ $task->issue_key }}
                                                    </a> — {{ $task->summary }}
                                                </div>
                                            @empty
                                                <p class="text-muted mb-0">No completed tasks.</p>
                                            @endforelse
                                        </div>
                                    </div>

                                    <!-- In Progress Tasks Collapse -->
                                    <div class="collapse mt-2" id="progress-{{ $slug }}">
                                        <div class="card card-body bg-light border-0">
                                            @forelse ($data['in_progress'] as $task)
                                                <div class="mb-2">
                                                    <i class="bi bi-clock-history text-warning me-1"></i>
                                                    <a href="{{ route('nld.show', $task) }}" class="text-decoration-none fw-semibold text-warning">
                                                        {{ $task->issue_key }}
                                                    </a> — {{ $task->summary }}
                                                </div>
                                            @empty
                                                <p class="text-muted mb-0">No in-progress tasks.</p>
                                            @endforelse
                                        </div>
                                    </div>

                                </li>
                            @empty
                                <li class="list-group-item text-muted">No group data</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
