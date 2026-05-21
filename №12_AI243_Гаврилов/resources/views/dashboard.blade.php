@extends('layouts.app')

@section('title', 'Дашбоард')

@section('content')
<div>
    <h1><i class="fas fa-chart-line"></i> Дашбоард</h1>

    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card">
                <h2>{{ $clientsCount }}</h2>
                <h5><i class="fas fa-users"></i> Клієнти</h5>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card warning">
                <h2>{{ $sessionsCount }}</h2>
                <h5><i class="fas fa-camera"></i> Фотоссесії</h5>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card success">
                <h2>{{ $managersCount }}</h2>
                <h5><i class="fas fa-user-tie"></i> Фотографи</h5>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card danger">
                <h2>{{ $upcomingSessions->count() }}</h2>
                <h5><i class="fas fa-calendar"></i> Найближчі</h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-check"></i> Найближчі фотоссесії
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($upcomingSessions->count() > 0)
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Назва</th>
                                    <th>Клієнт</th>
                                    <th>Дата та час</th>
                                    <th>Тип</th>
                                    <th>Статус</th>
                                    <th>Дії</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingSessions as $session)
                                    <tr>
                                        <td><strong>{{ $session->title }}</strong></td>
                                        <td>{{ $session->client->name }}</td>
                                        <td>
                                            <small>{{ $session->session_date->format('d.m.Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $session->type }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $session->getStatusBadgeColor() }}">
                                                {{ $session->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('photo-sessions.show', $session) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(Auth::user()->hasRole('admin') || Auth::id() === $session->manager_id)
                                                <a href="{{ route('photo-sessions.edit', $session) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info m-0">
                            <i class="fas fa-info-circle"></i> Немає планових фотоссесій
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

