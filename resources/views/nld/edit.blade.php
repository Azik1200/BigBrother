@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h1 class="fw-bold text-warning mb-4">
                            <i class="bi bi-pencil-square-fill me-2"></i> Edit NLD Group & Status
                        </h1>

                        <form action="{{ route('nld.update', $nld) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                @foreach([
                                    'Issue Key' => $nld->issue_key,
                                    'Description' => $nld->description ?? 'No description',
                                    'Reporter' => $nld->reporter_name,
                                    'Issue Type' => $nld->issue_type,
                                    'Updated' => $nld->updated ? \Carbon\Carbon::parse($nld->updated)->format('d.m.Y') : 'No data',
                                    'Created' => $nld->created ? \Carbon\Carbon::parse($nld->created)->format('d.m.Y') : 'No data',
                                    'Parent Issue Key' => $nld->parent_issue_key ?? 'No data',
                                    'NLD Issue Number' => $nld->parent_issue_number ?? 'No data',
                                    'Control Status' => $nld->control_status ?? 'No data',
                                    'Added' => $nld->add_date ? \Carbon\Carbon::parse($nld->add_date)->format('d.m.Y') : 'No data',
                                    'Sent' => $nld->send_date ? \Carbon\Carbon::parse($nld->send_date)->format('d.m.Y') : 'No data',
                                    'Completed' => $nld->done_date ? \Carbon\Carbon::parse($nld->done_date)->format('d.m.Y') : 'No data'
                                ] as $label => $value)
                                    <div class="col-md-6 mb-3">
                                        <div class="border rounded p-3 bg-light h-100">
                                            <label class="form-label fw-semibold text-secondary">{{ $label }}:</label>
                                            <p class="mb-0 text-dark">{{ $value }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr class="my-4">

                            <!-- Editable: Parent Issue Status -->
                            <div class="mb-4">
                                <label for="parent_issue_status" class="form-label fw-semibold">Parent Issue Status:</label>
                                <input
                                    type="text"
                                    name="parent_issue_status"
                                    id="parent_issue_status"
                                    class="form-control @error('parent_issue_status') is-invalid @enderror"
                                    value="{{ old('parent_issue_status', $nld->parent_issue_status) }}"
                                    placeholder="Enter status of parent issue"
                                >
                                @error('parent_issue_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Editable: Group -->
                            <div class="mb-4">
                                <label for="group_id" class="form-label fw-semibold">Reassign Group:</label>
                                <select name="group_id" id="group_id" class="form-select @error('group_id') is-invalid @enderror">
                                    <option value="" disabled selected>Select a group</option>
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

                            <!-- Actions -->
                            <div class="d-flex justify-content-start mt-4 gap-3">
                                <a href="{{ route('nld.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Back to List
                                </a>
                                <button type="submit" class="btn btn-warning text-dark">
                                    <i class="bi bi-save2-fill me-1"></i> Save Changes
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
