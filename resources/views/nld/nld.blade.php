@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">

                        <h1 class="fw-bold text-primary mb-4">
                            <i class="bi bi-eye-fill me-2"></i> View NLD
                        </h1>

                        <!-- Main Details -->
                        @foreach([
                            'ID' => $nld->id,
                            'Issue Key' => "<a href='https://jira-support.kapitalbank.az/browse/{$nld->issue_key}' target='_blank'>{$nld->issue_key}</a>",
                            'Summary' => $nld->summary ?? 'No description',
                            'Description' => $nld->description ?? 'No description',
                            'Group' => $nld->group->name ?? 'No group',
                            'Reporter' => $nld->reporter_name,
                            'Issue Type' => $nld->issue_type,
                            'Updated Date' => $nld->updated ? \Carbon\Carbon::parse($nld->updated)->format('d.m.Y') : 'No info',
                            'Creation Date' => $nld->created ? \Carbon\Carbon::parse($nld->created)->format('d.m.Y') : 'No info',
                            'Discovery Parent Issue' => $nld->parent_issue_key ?? 'No data',
                            'Parent Issue Status' => $nld->parent_issue_status ?? 'No data',
                            'Parent Issue Number' => $nld->parent_issue_number ?? 'No data',
                            'Control Status' => $nld->control_status ?? 'No data',
                            'Adding Date' => $nld->add_date ? \Carbon\Carbon::parse($nld->add_date)->format('d.m.Y') : 'No info',
                            'Sending Date' => $nld->send_date ? \Carbon\Carbon::parse($nld->send_date)->format('d.m.Y') : 'No info',
                            'Done Date' => $nld->done_date ? \Carbon\Carbon::parse($nld->done_date)->format('d.m.Y') : 'No info'
                        ] as $label => $value)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ $label }}:</label>
                                <p class="form-control-plaintext">{!! $value !!}</p>
                            </div>
                        @endforeach

                        <!-- Add Comment -->
                        <form action="{{ route('nld.comments.store', $nld) }}" method="POST" class="mt-5">
                            @csrf
                            <div class="mb-3">
                                <label for="comment" class="form-label fw-semibold">Add Comment:</label>
                                <textarea id="comment" name="comment" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-chat-dots-fill me-1"></i> Add Comment
                            </button>
                        </form>

                        <!-- Comments List -->
                        <div class="mt-5">
                            <h5 class="fw-bold mb-3">Comments:</h5>

                            @if($nld->comments->count())
                                @foreach ($nld->comments as $comment)
                                    <div class="card mb-3 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong>{{ $comment->user->name ?? 'Unknown User' }}</strong>
                                                </div>
                                                <div class="text-muted small">
                                                    {{ \Carbon\Carbon::parse($comment->created_at)->format('d.m.Y H:i') }}
                                                </div>
                                            </div>
                                            <hr>
                                            <p class="mb-0">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">There are no comments yet.</p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-start mt-4">
                            <a href="{{ route('nld.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back to List
                            </a>
                            <a href="{{ route('nld.edit', $nld) }}" class="btn btn-warning ms-2">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
