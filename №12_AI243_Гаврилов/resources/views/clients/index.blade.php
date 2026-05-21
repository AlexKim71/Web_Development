@extends('layouts.app')

@section('title', 'Клієнти')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-users"></i> Клієнти</h1>
        @if(Auth::user()->hasRole('admin'))
            <a href="{{ route('clients.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Новий клієнт
            </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($clients->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ім'я</th>
                                <th>Email</th>
                                <th>Телефон</th>
                                <th>Менеджер</th>
                                <th>Створено</th>
                                <th>Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td><strong>{{ $client->name }}</strong></td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone ?? '—' }}</td>
                                    <td>{{ $client->assignedManager->name ?? '—' }}</td>
                                    <td><small>{{ $client->created_at->format('d.m.Y') }}</small></td>
                                    <td>
                                        <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-info" title="Переглянути">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(Auth::user()->hasRole('admin'))
                                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning" title="Редагувати">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $client->id }}" title="Видалити">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $client->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Підтвердження видалення</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Ви впевнені, що хочете видалити клієнта <strong>{{ $client->name }}</strong>?
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
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $clients->links() }}
                </div>
            @else
                <div class="alert alert-info m-0">
                    <i class="fas fa-info-circle"></i> Немає клієнтів
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

