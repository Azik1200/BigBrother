@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h1 class="fw-bold text-warning mb-4">
                            <i class="bi bi-pencil-square-fill me-2"></i>Editing NLD Group
                        </h1>

                        <form action="{{ route('nld.update', $nld) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="issue_key" class="form-label fw-semibold">Title (Issue Key):</label>
                                <p class="form-control-plaintext">{{ $nld->issue_key }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Description:</label>
                                <p class="form-control-plaintext">{{ $nld->description ?? 'Нет описания' }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="reporter_name" class="form-label fw-semibold">Reporter:</label>
                                <p class="form-control-plaintext">{{ $nld->reporter_name }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="issue_type" class="form-label fw-semibold">Issue type:</label>
                                <p class="form-control-plaintext">{{ $nld->issue_type }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="updated" class="form-label fw-semibold">Date of update:</label>
                                <p class="form-control-plaintext">
                                    @if ($nld->updated)
                                        {{ \Carbon\Carbon::parse($nld->updated)->format('d.m.Y') }}
                                    @else
                                        No data
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <label for="created" class="form-label fw-semibold">Date of creation:</label>
                                <p class="form-control-plaintext">
                                    @if ($nld->created)
                                        {{ \Carbon\Carbon::parse($nld->created)->format('d.m.Y') }}
                                    @else
                                        No data
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <label for="parent_issue_key" class="form-label fw-semibold">Discovery Parent Issue Key:</label>
                                <p class="form-control-plaintext">{{ $nld->parent_issue_key ?? 'Нет' }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="parent_issue_status" class="form-label fw-semibold">Parent Issue Status:</label>
                                <p class="form-control-plaintext">{{ $nld->parent_issue_status ?? 'Нет' }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="parent_issue_number" class="form-label fw-semibold">NLD Issue number:</label>
                                <p class="form-control-plaintext">{{ $nld->parent_issue_number ?? 'Нет' }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="control_status" class="form-label fw-semibold">Control status:</label>
                                <p class="form-control-plaintext">{{ $nld->control_status ?? 'Нет' }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="add_date" class="form-label fw-semibold">Adding Date:</label>
                                <p class="form-control-plaintext">
                                    @if ($nld->add_date)
                                        {{ \Carbon\Carbon::parse($nld->add_date)->format('d.m.Y') }}
                                    @else
                                        No info
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <label for="send_date" class="form-label fw-semibold">Sending date:</label>
                                <p class="form-control-plaintext">
                                    @if ($nld->send_date)
                                        {{ \Carbon\Carbon::parse($nld->send_date)->format('d.m.Y') }}
                                    @else
                                        No info
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <label for="done_date" class="form-label fw-semibold">Completion date:</label>
                                <p class="form-control-plaintext">
                                    @if ($nld->done_date)
                                        {{ \Carbon\Carbon::parse($nld->done_date)->format('d.m.Y') }}
                                    @else
                                        No info
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <label for="group_id" class="form-label fw-semibold">Change group</label>
                                <select name="group_id" id="group_id" class="form-select @error('group_id') is-invalid @enderror">
                                    <option value="" selected>Select a group</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}" {{ old('group_id', $nld->group_id) == $group->id ? 'selected' : $group->name }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('group_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-start">
                                <a href="{{ route('nld') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Back to list
                                </a>
                                <button type="submit" class="btn btn-warning ms-2">
                                    <i class="bi bi-save-fill me-1"></i>Save group
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
