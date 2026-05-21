@extends('layouts.app')

@section('title', 'Фотоссесія: ' . $photoSession->title)

@section('content')
<div>
    <h1><i class="fas fa-camera"></i> {{ $photoSession->title }}</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Деталі фотоссесії</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="fas fa-heading"></i> Назва:</p>
                            <p class="h6">{{ $photoSession->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="fas fa-user"></i> Клієнт:</p>
                            <p class="h6">
                                <a href="{{ route('clients.show', $photoSession->client) }}">
                                    {{ $photoSession->client->name }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="fas fa-user-tie"></i> Фотограф:</p>
                            <p class="h6">{{ $photoSession->manager->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="fas fa-tag"></i> Тип:</p>
                            <p class="h6">
                                <span class="badge bg-info">{{ $photoSession->type }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="fas fa-calendar"></i> Дата та час:</p>
                            <p class="h6">{{ $photoSession->session_date->format('d.m.Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="fas fa-hourglass"></i> Тривалість:</p>
                            <p class="h6">{{ $photoSession->duration }} хвилин</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="fas fa-spinner"></i> Статус:</p>
                            <p class="h6">
                                <span class="badge bg-{{ $photoSession->getStatusBadgeColor() }}">
                                    {{ $photoSession->status }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="fas fa-clock"></i> Створено:</p>
                            <p class="h6">{{ $photoSession->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    @if($photoSession->description)
                    <div class="mb-3">
                        <p class="text-muted mb-1"><i class="fas fa-align-left"></i> Опис:</p>
                        <div class="alert alert-light border">
                            {{ $photoSession->description }}
                        </div>
                    </div>
                    @endif

                    @if(Auth::user()->hasRole('admin') || Auth::id() === $photoSession->manager_id)
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('photo-sessions.edit', $photoSession) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Редагувати
                        </a>
                        @if(Auth::user()->hasRole('admin'))
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> Видалити
                            </button>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Підтвердження видалення</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Ви впевнені, що хочете видалити фотоссесію <strong>{{ $photoSession->title }}</strong>? Цю дію неможливо скасувати.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Скасувати</button>
                                            <form action="{{ route('photo-sessions.destroy', $photoSession) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Видалити</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('photo-sessions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
                    </div>
                    @else
                    <div class="mt-4">
                        <a href="{{ route('photo-sessions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Інформація про клієнта</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>{{ $photoSession->client->name }}</strong>
                    </p>
                    <p class="mb-1">
                        <small class="text-muted">Email:</small><br>
                        <a href="mailto:{{ $photoSession->client->email }}">{{ $photoSession->client->email }}</a>
                    </p>
                    <p class="mb-0">
                        <small class="text-muted">Телефон:</small><br>
                        {{ $photoSession->client->phone ?? '—' }}
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-user-tie"></i> Фотограф</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>{{ $photoSession->manager->name }}</strong>
                    </p>
                    <p class="mb-1">
                        <small class="text-muted">Email:</small><br>
                        <a href="mailto:{{ $photoSession->manager->email }}">{{ $photoSession->manager->email }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

