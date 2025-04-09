@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h1 class="fw-bold text-primary mb-4">
                            <i class="bi bi-eye-fill me-2"></i>Просмотр NLD
                        </h1>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">ID:</label>
                            <p class="form-control-plaintext">{{ $nld->id }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Название:</label>
                            <p class="form-control-plaintext">{{ $nld->issue_key }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Описание:</label>
                            <p class="form-control-plaintext">{{ $nld->description ?? 'Нет описания' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">ID группы:</label>
                            <p class="form-control-plaintext">{{ $nld->group_id ?? 'Не указано' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Репортер:</label>
                            <p class="form-control-plaintext">{{ $nld->reporter_name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Тип проблемы:</label>
                            <p class="form-control-plaintext">{{ $nld->issue_type }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Дата обновления:</label>
                            <p class="form-control-plaintext">
                                @if ($nld->updated)
                                    {{ \Carbon\Carbon::parse($nld->updated)->format('d.m.Y') }}
                                @else
                                    Нет данных
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Дата создания:</label>
                            <p class="form-control-plaintext">
                                @if ($nld->created)
                                    {{ \Carbon\Carbon::parse($nld->created)->format('d.m.Y') }}
                                @else
                                    Нет данных
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ключ родительской задачи:</label>
                            <p class="form-control-plaintext">{{ $nld->parent_issue_key ?? 'Нет' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Статус родительской задачи:</label>
                            <p class="form-control-plaintext">{{ $nld->parent_issue_status ?? 'Нет' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Номер родительской задачи:</label>
                            <p class="form-control-plaintext">{{ $nld->parent_issue_number ?? 'Нет' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Статус контроля:</label>
                            <p class="form-control-plaintext">{{ $nld->control_status ?? 'Нет' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Дата добавления:</label>
                            <p class="form-control-plaintext">
                                @if ($nld->add_date)
                                    {{ \Carbon\Carbon::parse($nld->add_date)->format('d.m.Y') }}
                                @else
                                    Нет данных
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Дата отправки:</label>
                            <p class="form-control-plaintext">
                                @if ($nld->send_date)
                                    {{ \Carbon\Carbon::parse($nld->send_date)->format('d.m.Y') }}
                                @else
                                    Нет данных
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Дата выполнения:</label>
                            <p class="form-control-plaintext">
                                @if ($nld->done_date)
                                    {{ \Carbon\Carbon::parse($nld->done_date)->format('d.m.Y') }}
                                @else
                                    Нет данных
                                @endif
                            </p>
                        </div>

                        <form action="{{ route('comments.store', $nld->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="comment" class="form-label fw-semibold">Комментарий:</label>
                                <textarea id="comment" name="comment" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Добавить комментарий</button>
                        </form>

                        <!-- Список комментариев -->
                        @if($nld->comments != null)
                            @foreach ($nld->comments as $comment)
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <p><strong>{{ $comment->user->name ?? 'Неизвестный пользователь' }}</strong></p>
                                        <p>{{ $comment->comment }}</p>
                                        <p class="text-muted">
                                            {{ \Carbon\Carbon::parse($comment->created_at)->format('d.m.Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Комментариев нет.</p>
                        @endif
                    </div>

                        <div class="d-flex justify-content-start">
                            <a href="{{ route('nld') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Назад к списку
                            </a>
                            <a href="" class="btn btn-outline-warning ms-2">
                                <i class="bi bi-pencil-square me-1"></i>Редактировать
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
