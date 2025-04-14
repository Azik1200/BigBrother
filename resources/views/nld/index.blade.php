@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')


    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">NLD List</h1>
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('nld.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create NLD
                </a>
            @endif
        </div>
        <form method="GET" action="{{ route('nld') }}" class="mb-4">
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
                <div class="col-md-2 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('nld') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>


        <div class="list-group">
            @if($nlds->count())
                @foreach($nlds as $nld)
                    @if(auth()->check() && !auth()->user()->isAdmin() && auth()->user()->groups[0]->id == $nld->group_id || auth()->check() && auth()->user()->isAdmin())
                        @php
                            $doneDate = $nld->done_date;
                            $addedDate = $nld->add_date;
                            $bgClass = '';

                            if ($doneDate) {
                                $bgClass = 'bg-success bg-opacity-25';
                            } elseif ($addedDate) {
                                $daysDiff = \Carbon\Carbon::parse($addedDate)->diffInDays(\Carbon\Carbon::now());

                                if ($daysDiff > 5) {
                                    $bgClass = 'bg-danger bg-opacity-25';
                                } elseif ($daysDiff > 3) {
                                    $bgClass = 'bg-warning bg-opacity-25';
                                }
                            }
                        @endphp

                        <div class="list-group-item py-3 {{ $bgClass }}">
                            <h5 class="mb-1">
                                <a href="https://jira-support.kapitalbank.az/browse/{{ $nld->issue_key }}"
                                   target="_blank">
                                    {{ $nld->issue_key }}
                                </a>
                            </h5>

                            <p class="mb-1 text-muted">{{ Str::limit($nld->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-person-fill me-1"></i> Reporter: {{ $nld->reporter_name }} |
                                    <i class="bi"></i> Control Status: {{ $nld->control_status }} |
                                    <i class="bi bi-calendar-check me-1"></i> Updated:
                                    @if ($nld->updated)
                                        {{ \Carbon\Carbon::parse($nld->updated)->format('d.m.Y') }}
                                    @else
                                        No info
                                    @endif
                                </small>
                                <div>
                                    <a href="{{ route('nld.show', $nld) }}" class="btn btn-outline-info btn-sm me-2">
                                        Read more
                                    </a>
                                    <form action="{{ route('nld.done', $nld) }}" method="POST"
                                          style="display:inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-success btn-sm">Finished</button>
                                    </form>
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <a href="{{ route('nld.edit', $nld) }}"
                                           class="btn btn-outline-warning btn-sm me-2">
                                            Edit
                                        </a>
                                        <form action="" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <p class="text-muted">There are no NLD records.</p>
            @endif
        </div>
    </div>
@endsection
