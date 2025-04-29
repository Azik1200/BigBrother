@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h1 class="fw-bold text-warning mb-4">
                            <i class="bi bi-pencil-square-fill me-2"></i> Editing NLD Group
                        </h1>

                        <form action="{{ route('nld.update', $nld) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Read-only fields -->
                            @foreach([
                                'Issue Key' => $nld->issue_key,
                                'Description' => $nld->description ?? 'No description',
                                'Reporter' => $nld->reporter_name,
                                'Issue type' => $nld->issue_type,
                                'Date of update' => $nld->updated ? \Carbon\Carbon::parse($nld->updated)->format('d.m.Y') : 'No data',
                                'Date of creation' => $nld->created ? \Carbon\Carbon::parse($nld->created)->format('d.m.Y') : 'No data',
                                'Discovery Parent Issue Key' => $nld->parent_issue_key ?? 'No data',
                                'NLD Issue number' => $nld->parent_issue_number ?? 'No data',
                                'Control status' => $nld->control_status ?? 'No data',
                                'Adding Date' => $nld->add_date ? \Carbon\Carbon::parse($nld->add_date)->format('d.m.Y') : 'No data',
                                'Sending date' => $nld->send_date ? \Carbon\Carbon::parse($nld->send_date)->format('d.m.Y') : 'No data',
                                'Completion date' => $nld->done_date ? \Carbon\Carbon::parse($nld->done_date)->format('d.m.Y') : 'No data'
                            ] as $label => $value)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ $label }}:</label>
                                    <p class="form-control-plaintext">{{ $value }}</p>
                                </div>
                            @endforeach

                            <!-- Editable field: Parent Issue Status -->
                            <div class="mb-4">
                                <label for="parent_issue_status" class="form-label fw-semibold">Parent Issue Status:</label>
                                <input
                                    type="text"
                                    name="parent_issue_status"
                                    id="parent_issue_status"
                                    class="form-control @error('parent_issue_status') is-invalid @enderror"
                                    value="{{ old('parent_issue_status', $nld->parent_issue_status) }}"
                                    placeholder="Enter Parent Issue Status"
                                >
                                @error('parent_issue_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Editable field: Group -->
                            <div class="mb-4">
                                <label for="group_id" class="form-label fw-semibold">Change Group:</label>
                                <select name="group_id" id="group_id" class="form-select @error('group_id') is-invalid @enderror">
                                    <option value="" disabled>Select a group</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}" {{ old('group_id', $nld->group_id) == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('group_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('nld.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Back to list
                                </a>
                                <button type="submit" class="btn btn-warning ms-2">
                                    <i class="bi bi-save-fill me-1"></i> Save Changes
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
