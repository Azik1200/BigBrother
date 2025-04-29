@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">NLD List</h1>
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('nld.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-2"></i> Create NLD
                </a>
            @endif
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('nld.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-2">
                    <input type="text" name="issue_key" value="{{ request('issue_key') }}" class="form-control" placeholder="Issue Key">
                </div>
                <div class="col-md-2">
                    <input type="text" name="reporter_name" value="{{ request('reporter_name') }}" class="form-control" placeholder="Reporter Name">
                </div>
                <div class="col-md-2">
                    <select name="issue_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="OP-Risk" @selected(request('issue_type') == 'OP-Risk')>OP-Risk</option>
                        <option value="Incident" @selected(request('issue_type') == 'Incident')>Incident</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="group_id" class="form-select">
                        <option value="">All Groups</option>
                        <option value="null" @selected(request('group_id') === 'null')>No Group</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" @selected(request('group_id') == $group->id)>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="done" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="1" @selected(request('done') == '1')>Finished</option>
                        <option value="0" @selected(request('done') == '0')>In Progress</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="per_page" class="form-select">
                        <option value="10" @selected(request('per_page') == 10)>10 per page</option>
                        <option value="25" @selected(request('per_page') == 25)>25 per page</option>
                        <option value="50" @selected(request('per_page') == 50)>50 per page</option>
                    </select>
                </div>
                <div class="col-md-12 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('nld.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <!-- NLD List -->
        <div class="list-group">
            @forelse($nlds as $nld)
                @php
                    $doneDate = $nld->done_date;
                    $addedDate = $nld->add_date;
                    $bgClass = '';

                    if ($doneDate) {
                        $bgClass = 'bg-success bg-opacity-25';
                    } elseif ($addedDate) {
                        $daysDiff = Carbon::parse($addedDate)->diffInDays(Carbon::now());

                        if ($daysDiff > 5) {
                            $bgClass = 'bg-danger bg-opacity-25';
                        } elseif ($daysDiff > 3) {
                            $bgClass = 'bg-warning bg-opacity-25';
                        }
                    }

                    $canView = auth()->check() && (auth()->user()->isAdmin() || auth()->user()->groups->pluck('id')->contains($nld->group_id));
                @endphp

                @if($canView)
                    <div class="list-group-item py-4 rounded-2 shadow-sm mb-3 {{ $bgClass }}">
                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                            <div class="flex-grow-1">
                                <h5 class="mb-2">
                                    <a href="https://jira-support.kapitalbank.az/browse/{{ $nld->issue_key }}"
                                       target="_blank"
                                       class="text-decoration-none text-primary">
                                        {{ $nld->issue_key }}
                                    </a>
                                </h5>
                                <p class="text-muted mb-2">{{ Str::limit($nld->description, 100) }}</p>

                                <div class="small text-muted">
                                    <i class="bi bi-person-fill me-1"></i> Reporter: {{ $nld->reporter_name }} |
                                    <i class="bi bi-people me-1"></i> Group:
                                    @if ($nld->group)
                                        <span class="text-dark fw-semibold">{{ $nld->group->name }}</span>
                                    @else
                                        <span class="text-muted">No group</span>
                                    @endif
                                    |
                                    <i class="bi bi-clipboard-check me-1"></i> Status: {{ $nld->control_status }} |
                                    <i class="bi bi-calendar-check me-1"></i> Updated:
                                    {{ $nld->updated ? Carbon::parse($nld->updated)->format('d.m.Y') : 'No info' }}
                                </div>

                            </div>

                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <a href="{{ route('nld.show', $nld) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye me-1"></i> Read More
                                </a>

                                @if(!$doneDate)
                                    <form action="{{ route('nld.done', $nld) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle me-1"></i> Mark as Finished
                                        </button>
                                    </form>
                                @endif

                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('nld.edit', $nld) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>

                                    <form action="{{ route('nld.destroy', $nld) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-muted">There are no NLD records available.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $nlds->links() }}
        </div>
    </div>
@endsection
