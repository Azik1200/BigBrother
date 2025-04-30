@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">

                        <h1 class="fw-bold text-primary mb-4">
                            <i class="bi bi-info-circle-fill me-2"></i> NLD Details
                        </h1>

                        <div class="row">
                            @foreach([
                                'Issue Key' => "<a href='https://jira-support.kapitalbank.az/browse/{$nld->issue_key}' target='_blank'>{$nld->issue_key}</a>",
                                'Summary' => $nld->summary ?? 'No summary',
                                'Description' => nl2br(e($nld->description ?? 'No description')),
                                'Group' => $nld->group->name ?? 'No group',
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
                                'Done Date' => $nld->done_date ? \Carbon\Carbon::parse($nld->done_date)->format('d.m.Y') : 'No info',
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
                            <a href="{{ route('nld.edit', $nld) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square me-1"></i> Edit NLD
                            </a>
                            @auth
                                @if($nld->group_id && auth()->user()->groups->pluck('id')->contains($nld->group_id))
                                    <form action="{{ route('nld.unassign', $nld) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-person-x me-1"></i> Unassign from Group
                                        </button>
                                    </form>
                                @endif
                            @endauth

                            @if(!$doneDate)
                                <form action="{{ route('nld.done', $nld) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-circle me-1"></i> Mark as Finished
                                    </button>
                                </form>
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

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
