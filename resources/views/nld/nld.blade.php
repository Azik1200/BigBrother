@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @php
                    $allGroupIds = $nld->groups->pluck('id')->sort()->values()->toArray();
                    $doneGroupIds = $nld->doneStatuses->pluck('group_id')->sort()->values()->toArray();

                    $isFullyDone = !empty($allGroupIds) && $allGroupIds === $doneGroupIds;

                    $bgClass = '';

                    if ($isFullyDone) {
                        $bgClass = 'bg-success bg-opacity-10';
                    } elseif ($nld->send_date) {
                        $daysSinceSend = \Carbon\Carbon::parse($nld->send_date)->diffInDays(now());

                        if ($daysSinceSend >= 7) {
                            $bgClass = 'bg-danger bg-opacity-10';
                        } elseif ($daysSinceSend >= 3) {
                            $bgClass = 'bg-warning bg-opacity-10';
                        } else {
                            $bgClass = 'bg-light';
                        }
                    } elseif ($nld->add_date) {
                        $daysSinceAdd = \Carbon\Carbon::parse($nld->add_date)->diffInDays(now());

                        if ($daysSinceAdd >= 7) {
                            $bgClass = 'bg-primary bg-opacity-10';
                        } elseif ($daysSinceAdd >= 3) {
                            $bgClass = 'bg-info bg-opacity-10';
                        } else {
                            $bgClass = 'bg-light';
                        }
                    }
                @endphp

                <div class="card shadow-lg border-0 {{ $bgClass }}">
                    <div class="card-body p-5">
                        <h1 class="fw-bold text-primary mb-4">
                            <i class="bi bi-info-circle-fill me-2"></i> NLD Details
                        </h1>

                        <div class="row">
                            @foreach([
                                'Issue Key' => "<a href='https://jira-support.kapitalbank.az/browse/{$nld->issue_key}' target='_blank'>{$nld->issue_key}</a>",
                                'Summary' => $nld->summary ?? 'No summary',
                                'Description' => nl2br(e($nld->description ?? 'No description')),
                                'Groups' => $nld->groups->where('name', '!=', 'admin')->isNotEmpty()
    ? $nld->groups->where('name', '!=', 'admin')->pluck('name')->join(', ')
    : 'No groups',
                                'Reporter' => $nld->reporter_name,
                                'Issue Type' => $nld->issue_type,
                                'Updated Date' => $nld->updated ? \Carbon\Carbon::parse($nld->updated)->format('d.m.Y') : 'No info',
                                'Creation Date' => $nld->created ? \Carbon\Carbon::parse($nld->created)->format('d.m.Y') : 'No info',
                                'Parent Issue Key' => $nld->parent_issue_key ?? 'No data',
                                'Parent Status' => $nld->parent_issue_status ?? 'No data',
                                'Parent Number' => $nld->parent_issue_number ?? 'No data',
                                'Control Status' => $nld->control_status ?? 'No data',
                                'Adding Date' => $nld->add_date ? \Carbon\Carbon::parse($nld->add_date)->format('d.m.Y') : 'No info',
                                'Sending Date' => $nld->send_date ? \Carbon\Carbon::parse($nld->send_date)->format('d.m.Y') : 'No info',
                                'Done By Groups' => $nld->doneStatuses->isNotEmpty()
    ? $nld->doneStatuses->map(fn($status) =>
        "{$status->group->name} on " .
        \Carbon\Carbon::parse($status->done_at)->format('d.m.Y H:i')
    )->join('<br>')
    : 'No group has completed this task',
                            ] as $label => $value)
                                <div class="col-md-6 mb-4">
                                    <div class="border rounded p-3 bg-light h-100">
                                        <label class="form-label fw-semibold text-secondary">{{ $label }}:</label>
                                        <div class="text-dark">{!! $value !!}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr class="my-5">

                        <!-- Comments Section -->
                        <div class="mb-5">
                            <h4 class="fw-bold mb-3 text-primary">
                                <i class="bi bi-chat-dots me-1"></i> Comments
                            </h4>

                            @forelse ($nld->comments as $comment)
                                <div class="card mb-3 border-start border-4 border-primary shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="fw-semibold">
                                                <i class="bi bi-person-circle me-1 text-secondary"></i>
                                                {{ $comment->user->name ?? 'Unknown User' }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ \Carbon\Carbon::parse($comment->created_at)->format('d.m.Y H:i') }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="text-dark">{{ $comment->comment }}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">There are no comments yet.</p>
                            @endforelse
                        </div>

                        <!-- Add Comment -->
                        <form action="{{ route('nld.comments.store', $nld) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="comment" class="form-label fw-semibold">Add Comment:</label>
                                <textarea id="comment" name="comment" class="form-control" rows="3" required placeholder="Type your comment here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Submit Comment
                            </button>
                        </form>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3">
                            <a href="{{ route('nld.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back to List
                            </a>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('nld.edit', $nld) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil-square me-1"></i> Edit NLD
                                    </a>
                                @endif
                            @endauth
                            @auth
                                @php
                                    $userGroupIds = auth()->user()->groups->pluck('id');
                                    $assignedGroupIds = $nld->groups->pluck('id');
                                    $doneGroupIds = $nld->doneStatuses->pluck('group_id');

                                    $isFullyDone = $assignedGroupIds->count() > 0 &&
                                                   $assignedGroupIds->diff($doneGroupIds)->isEmpty();
                                @endphp

                                @if(!$isFullyDone && $assignedGroupIds->intersect($userGroupIds)->isNotEmpty())
                                    <form action="{{ route('nld.unassign', $nld) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-person-x me-1"></i> Unassign from Group
                                        </button>
                                    </form>
                                @endif
                            @endauth


                        @if ($nld->doneStatuses->isNotEmpty())
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reopenModal">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reopen for Group
                                </button>
                            @endif

                        @if ($nld->done_date)
                                <form action="{{ route('nld.reopen', $nld) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Mark as In Progress
                                    </button>
                                </form>
                            @endif
                            @auth
                                @php
                                    $userGroupIds = auth()->user()->groups->pluck('id')->toArray();
                                    $nldGroupIds = $nld->groups->pluck('id')->toArray();
                                    $doneGroupIds = $nld->doneStatuses->pluck('group_id')->toArray();

                                    $eligibleGroupIds = array_diff(
                                        array_intersect($userGroupIds, $nldGroupIds),
                                        $doneGroupIds
                                    );
                                @endphp

                                @if (!empty($eligibleGroupIds))
                                    <form action="{{ route('nld.done', $nld) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle me-1"></i> Mark as Finished
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($nld->doneStatuses->isNotEmpty())
            <!-- Reopen Modal -->
            <div class="modal fade" id="reopenModal" tabindex="-1" aria-labelledby="reopenModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('nld.reopen', $nld) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reopenModalLabel">Reopen Task for Group</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            @if($errors->any())
                                <div class="alert alert-danger mt-3">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            <div class="modal-body">
                                <label for="group_id" class="form-label">Select Group to Reopen</label>
                                <select name="group_id" id="group_id" class="form-select mb-3" required>
                                    @foreach($nld->doneStatuses as $status)
                                        <option value="{{ $status->group_id }}">
                                            {{ $status->group->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <label for="comment" class="form-label">Comment (required)</label>
                                <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Provide a reason for reopening..." required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Reopen Task</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
