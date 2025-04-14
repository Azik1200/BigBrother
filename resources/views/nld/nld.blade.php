@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h1 class="fw-bold text-primary mb-4">
                            <i class="bi bi-eye-fill me-2"></i>View NLD
                        </h1>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">ID:</label>
                            <p class="form-control-plaintext">{{ $nld->id }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Issue key:</label>
                            <p class="form-control-plaintext">
                                <a href="https://jira-support.kapitalbank.az/browse/{{ $nld->issue_key }}" target="_blank">
                                    {{ $nld->issue_key }}
                                </a>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Summary:</label>
                            <p class="form-control-plaintext">{{ $nld->summary ?? 'Нет описания' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description:</label>
                            <p class="form-control-plaintext">{{ $nld->description ?? 'Нет описания' }}</p>
                        </div>


                        <div class="mb-3">
                            <label class="form-label fw-semibold">Group:</label>
                            <p class="form-control-plaintext">{{ $nld->group->name ?? 'No group' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Reporter:</label>
                            <p class="form-control-plaintext">{{ $nld->reporter_name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Issue type:</label>
                            <p class="form-control-plaintext">{{ $nld->issue_type }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Updated date:</label>
                            <p class="form-control-plaintext">
                                @if ($nld->updated)
                                    {{ \Carbon\Carbon::parse($nld->updated)->format('d.m.Y') }}
                                @else
                                    No info
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Creation date:</label>
                            <p class="form-control-plaintext">
                                @if ($nld->created)
                                    {{ \Carbon\Carbon::parse($nld->created)->format('d.m.Y') }}
                                @else
                                    No info
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Discovery Parent Issue:</label>
                            <p class="form-control-plaintext">{{ $nld->parent_issue_key ?? 'Нет' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Parent Issue Status:</label>
                            <p class="form-control-plaintext">{{ $nld->parent_issue_status ?? 'Нет' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Parent Issue Number:</label>
                            <p class="form-control-plaintext">{{ $nld->parent_issue_number ?? 'Нет' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Control Status:</label>
                            <p class="form-control-plaintext">{{ $nld->control_status ?? 'Нет' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Adding Date:</label>
                            <p class="form-control-plaintext">
                                @if ($nld->add_date)
                                    {{ \Carbon\Carbon::parse($nld->add_date)->format('d.m.Y') }}
                                @else
                                    No info
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sending Date:</label>
                            <p class="form-control-plaintext">
                                @if ($nld->send_date)
                                    {{ \Carbon\Carbon::parse($nld->send_date)->format('d.m.Y') }}
                                @else
                                    No info
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Done Date:</label>
                            <p class="form-control-plaintext">
                                @if ($nld->done_date)
                                    {{ \Carbon\Carbon::parse($nld->done_date)->format('d.m.Y') }}
                                @else
                                    No info
                                @endif
                            </p>
                        </div>

                        <form action="{{ route('comments.store', $nld->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="comment" class="form-label fw-semibold">Comments:</label>
                                <textarea id="comment" name="comment" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add comment</button>
                        </form>

                        <!-- Список комментариев -->
                        @if($nld->comments != null)
                            @foreach ($nld->comments as $comment)
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <p><strong>{{ $comment->user->name ?? 'Unknown user' }}</strong></p>
                                        <p>{{ $comment->comment }}</p>
                                        <p class="text-muted">
                                            {{ \Carbon\Carbon::parse($comment->created_at)->format('d.m.Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>There are no comments.</p>
                        @endif
                    </div>

                        <div class="d-flex justify-content-start">
                            <a href="{{ route('nld') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Back to list
                            </a>
                            <a href="" class="btn btn-outline-warning ms-2">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
