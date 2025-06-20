@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;
@endphp
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
                    <div class="dropdown w-100">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ request('issue_type', 'All Types') ?: 'All Types' }}
                        </button>
                        <div class="dropdown-menu p-2 w-100">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="issue_type" value="" id="issueTypeAll" @checked(!request('issue_type'))>
                                <label class="form-check-label" for="issueTypeAll">All Types</label>
                            </div>
                            @foreach($issueTypes as $type)
                                @php $slug = Str::slug($type); @endphp
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="issue_type" value="{{ $type }}" id="issueType-{{ $slug }}" @checked(request('issue_type') == $type)>
                                    <label class="form-check-label" for="issueType-{{ $slug }}">{{ $type }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if(auth()->user()->isAdmin())
                    <div class="col-md-2">
                        <div class="dropdown w-100">
                            <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @php
                                    $selectedGroup = '';
                                    if(request('group_id') === 'null') {
                                        $selectedGroup = 'No Group';
                                    } elseif(request('group_id')) {
                                        $selectedGroup = $groups->firstWhere('id', request('group_id'))->name ?? '';
                                    }
                                @endphp
                                {{ $selectedGroup ?: 'All Groups' }}
                            </button>
                            <div class="dropdown-menu p-2 w-100">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_id" value="" id="groupAll" @checked(!request('group_id'))>
                                    <label class="form-check-label" for="groupAll">All Groups</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_id" value="null" id="groupNull" @checked(request('group_id') === 'null')>
                                    <label class="form-check-label" for="groupNull">No Group</label>
                                </div>
                                @foreach ($groups->where('name', '!=', 'admin') as $group)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="group_id" value="{{ $group->id }}" id="group_{{ $group->id }}" @checked(request('group_id') == $group->id)>
                                        <label class="form-check-label" for="group_{{ $group->id }}">{{ $group->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-2">
                    <div class="dropdown w-100">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @php
                                $doneLabel = match(request('done')) {
                                    '1' => 'Finished',
                                    '0' => 'In Progress',
                                    default => 'All Statuses'
                                };
                            @endphp
                            {{ $doneLabel }}
                        </button>
                        <div class="dropdown-menu p-2 w-100">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="done" value="" id="doneAll" @checked(!request('done'))>
                                <label class="form-check-label" for="doneAll">All Statuses</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="done" value="1" id="doneFinished" @checked(request('done') == '1')>
                                <label class="form-check-label" for="doneFinished">Finished</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="done" value="0" id="doneProgress" @checked(request('done') == '0')>
                                <label class="form-check-label" for="doneProgress">In Progress</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="dropdown w-100">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Parent Statuses
                        </button>
                        <div class="dropdown-menu p-2 w-100">
                            @foreach($parentStatuses as $status)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="parent_issue_status[]" value="{{ $status }}" id="status-{{ Str::slug($status) }}" @checked(collect(request('parent_issue_status'))->contains($status))>
                                    <label class="form-check-label" for="status-{{ Str::slug($status) }}">{{ $status }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="dropdown w-100">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ request('per_page', 10) }} per page
                        </button>
                        <div class="dropdown-menu p-2 w-100">
                            @foreach([10,25,50] as $size)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="per_page" value="{{ $size }}" id="perPage{{ $size }}" @checked(request('per_page', 10) == $size)>
                                    <label class="form-check-label" for="perPage{{ $size }}">{{ $size }} per page</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-12 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('nld.index') }}" class="btn btn-secondary">Reset</a>
                    <a href="{{ route('nld.export', request()->query()) }}" class="btn btn-outline-success">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export to Excel
                    </a>
                </div>
            </div>
        </form>

        <div class="alert alert-info d-flex align-items-center gap-2">
            <i class="bi bi-info-circle-fill"></i>
            <div>
                {{ $nlds->total() }} {{ Str::plural('record', $nlds->total()) }} found matching your filters.
            </div>
        </div>

        <!-- NLD List -->
        <div class="list-group">
            @forelse($nlds as $nld)
                @php
                    $nldGroups = $nld->groups ?? collect();
                    $groupIds = $nldGroups->pluck('id')->map(fn($id) => (int)$id)->sort()->values();
                    $doneGroupIds = $nld->doneStatuses->pluck('group_id')->map(fn($id) => (int)$id)->sort()->values();

                    $isFullyDone = $nld->parent_issue_status === 'done' && $groupIds->count() > 0 && $groupIds->diff($doneGroupIds)->isEmpty() && $doneGroupIds->diff($groupIds)->isEmpty();

                    $bgClass = '';

                    if ($nld->parent_issue_status === 'done') {
                        if ($isFullyDone) {
                            $bgClass = 'bg-success bg-opacity-25';
                        } elseif ($nld->send_date) {
                            $daysSinceSend = \Carbon\Carbon::parse($nld->send_date)->diffInDays(now());

                            if ($daysSinceSend >= 7) {
                                $bgClass = 'bg-danger bg-opacity-25';
                            } elseif ($daysSinceSend >= 3) {
                                $bgClass = 'bg-pink bg-opacity-25';
                            } else {
                                $bgClass = 'bg-light';
                            }
                        } elseif ($nld->add_date) {
                            $daysSinceAdd = \Carbon\Carbon::parse($nld->add_date)->diffInDays(now());

                            if ($daysSinceAdd >= 3 && is_null($nld->send_date)) {
                                $bgClass = 'bg-danger bg-opacity-25';
                            } else {
                                $bgClass = 'bg-light';
                            }
                        }
                    } else {
                        $bgClass = 'bg-light';
                    }
                @endphp

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
                                <i class="bi bi-people me-1"></i> Groups:
                                @if ($nldGroups->isNotEmpty())
                                    @foreach($nldGroups->where('name', '!=', 'admin') as $group)
                                        <span class="badge bg-secondary me-1">{{ $group->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No group</span>
                                @endif
                                |
                                <i class="bi bi-clipboard-check me-1"></i> Status: {{ $nld->control_status }} |
                                <i class="bi bi-calendar-check me-1"></i> Updated:
                                {{ $nld->updated ? Carbon::parse($nld->updated)->format('d.m.Y') : 'No info' }}
                                |
                                <i class="bi bi-journal-text me-1"></i> Parent Status: {{ $nld->parent_issue_status ?? 'No data' }}
                            </div>
                        </div>

                        <div class="mt-3 d-flex flex-wrap gap-2">
                            <a href="{{ route('nld.show', $nld) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye me-1"></i> Read More
                            </a>

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
