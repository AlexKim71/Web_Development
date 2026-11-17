@extends('layouts.app')

@section('title', 'Фотоссесії')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-camera"></i> Фотоссесії</h1>
        @if(Auth::user()->hasRole('admin'))
            <a href="{{ route('photo-sessions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Нова фотоссесія
            </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($sessions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Назва</th>
                                <th>Клієнт</th>
                                <th>Фотограф</th>
                                <th>Дата</th>
                                <th>Тип</th>
                                <th>Статус</th>
                                <th>Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $session)
                                <tr>
                                    <td><strong>{{ $session->title }}</strong></td>
                                    <td>{{ $session->client->name }}</td>
                                    <td>{{ $session->manager->name }}</td>
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
                                        <a href="{{ route('photo-sessions.show', $session) }}" class="btn btn-sm btn-info" title="Переглянути">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(Auth::user()->hasRole('admin') || Auth::id() === $session->manager_id)
                                            <a href="{{ route('photo-sessions.edit', $session) }}" class="btn btn-sm btn-warning" title="Редагувати">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(Auth::user()->hasRole('admin'))
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $session->id }}" title="Видалити">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $session->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Підтвердження видалення</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Ви впевнені, що хочете видалити фотоссесію <strong>{{ $session->title }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Скасувати</button>
                                                            <form action="{{ route('photo-sessions.destroy', $session) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Видалити</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $sessions->links() }}
                </div>
            @else
                <div class="alert alert-info m-0">
                    <i class="fas fa-info-circle"></i> Немає фотоссесій
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

