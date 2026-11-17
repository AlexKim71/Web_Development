@extends('layouts.app')

@section('title', 'Редагування фотоссесії')

@section('content')
<div>
    <h1><i class="fas fa-camera-edit"></i> Редагування: {{ $photoSession->title }}</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Форма редагування</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('photo-sessions.update', $photoSession) }}" method="POST" novalidate class="needs-validation">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="title" class="form-label">Назва <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $photoSession->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Опис</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $photoSession->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="session_date" class="form-label">Дата та час <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('session_date') is-invalid @enderror" id="session_date" name="session_date" value="{{ old('session_date', $photoSession->session_date->format('Y-m-d\TH:i')) }}" required>
                                    @error('session_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Тривалість (хвилини) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration', $photoSession->duration) }}" required>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Тип фотоссесії <span class="text-danger">*</span></label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="весільна" {{ old('type', $photoSession->type) === 'весільна' ? 'selected' : '' }}>🤵 Весільна</option>
                                        <option value="сімейна" {{ old('type', $photoSession->type) === 'сімейна' ? 'selected' : '' }}>👨‍👩‍👧‍👦 Сімейна</option>
                                        <option value="портретна" {{ old('type', $photoSession->type) === 'портретна' ? 'selected' : '' }}>👤 Портретна</option>
                                        <option value="інші" {{ old('type', $photoSession->type) === 'інші' ? 'selected' : '' }}>📸 Інші</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Статус <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="нові" {{ old('status', $photoSession->status) === 'нові' ? 'selected' : '' }}>Нові</option>
                                        <option value="в процесі" {{ old('status', $photoSession->status) === 'в процесі' ? 'selected' : '' }}>В процесі</option>
                                        <option value="завершено" {{ old('status', $photoSession->status) === 'завершено' ? 'selected' : '' }}>Завершено</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_id" class="form-label">Клієнт <span class="text-danger">*</span></label>
                                    <select class="form-control @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" {{ old('client_id', $photoSession->client_id) == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="manager_id" class="form-label">Фотограф <span class="text-danger">*</span></label>
                                    <select class="form-control @error('manager_id') is-invalid @enderror" id="manager_id" name="manager_id" required>
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->id }}" {{ old('manager_id', $photoSession->manager_id) == $manager->id ? 'selected' : '' }}>
                                                {{ $manager->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('manager_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Зберегти
                            </button>
                            <a href="{{ route('photo-sessions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Назад
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

