@extends('layouts.app')

@section('title', 'Group Management')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">

                        <h1 class="fw-bold text-primary mb-4">
                            <i class="bi bi-people-fill me-2"></i> Group: {{ $group->name }}
                        </h1>

                        <p class="text-muted">
                            <i class="bi bi-person-lines-fill me-1"></i>
                            <strong>Number of Participants:</strong> {{ $membersCount }}
                        </p>

                        <hr class="my-4">

                        <h5 class="fw-semibold mb-3 text-secondary">
                            <i class="bi bi-person-check me-1"></i> Participants
                        </h5>

                        @if ($group->members->isEmpty())
                            <p class="text-muted">There are no members in the group yet.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($group->members as $member)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            {{ $member->name }} <span class="text-muted">({{ $member->email }})</span>
                                        </div>

                                        <form
                                            action="{{ route('admin.groups.removeMember', ['group' => $group->id, 'user' => $member->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to remove {{ $member->name }} from the group?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-x-circle me-1"></i> Remove
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.groups.addMembers', $group->id) }}" class="btn btn-success">
                                <i class="bi bi-person-plus-fill me-1"></i> Add Participants
                            </a>
                            <a href="{{ route('admin.groups.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left-circle me-2"></i> Back to Group List
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
