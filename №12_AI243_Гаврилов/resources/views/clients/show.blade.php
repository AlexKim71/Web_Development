@extends('layouts.app')

@section('title', 'Клієнт: ' . $client->name)

@section('content')
<div>
    <h1><i class="fas fa-user"></i> {{ $client->name }}</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Інформація про клієнта</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Ім'я:</p>
                            <p class="h6">{{ $client->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Email:</p>
                            <p class="h6">
                                <a href="mailto:{{ $client->email }}">{{ $client->email }}</a>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Телефон:</p>
                            <p class="h6">{{ $client->phone ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Менеджер:</p>
                            <p class="h6">{{ $client->assignedManager->name ?? '—' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Дата реєстрації:</p>
                            <p class="h6">{{ $client->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Остання зміна:</p>
                            <p class="h6">{{ $client->updated_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    @if(Auth::user()->hasRole('admin'))
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Редагувати
                        </a>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Видалити
                        </button>
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Підтвердження видалення</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Ви впевнені, що хочете видалити клієнта <strong>{{ $client->name }}</strong>? Цю дію неможливо скасувати.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Скасувати</button>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Видалити</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="mt-4">
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-camera"></i> Фотоссесії</h5>
                </div>
                <div class="card-body p-0">
                    @if($client->photoSessions->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($client->photoSessions as $session)
                                <li class="list-group-item">
                                    <a href="{{ route('photo-sessions.show', $session) }}" class="text-decoration-none">
                                        <strong>{{ $session->title }}</strong>
                                    </a>
                                    <br>
                                    <small class="text-muted">
                                        {{ $session->session_date->format('d.m.Y H:i') }}
                                    </small>
                                    <br>
                                    <span class="badge bg-{{ $session->getStatusBadgeColor() }}">
                                        {{ $session->status }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-info m-3">
                            Немає фотоссесій
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

