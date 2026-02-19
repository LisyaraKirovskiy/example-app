@extends('layouts.main')
@section('title', 'Профиль: ' . $user->name)

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-user me-2"></i>Профиль пользователя
                            </h4>
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-light">
                                ← Назад
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <div class="d-flex flex-row">
                                    <div class="rounded-circle bg-gradient d-flex align-items-center justify-content-center text-white fw-bold shadow-sm"
                                        style="width: 80px; height: 80px; background: #6366f1; margin-left: 80px;"
                                        id="circle">
                                        <img id="avatar" src="{{ asset($user->avatarPath()) }}" alt="Avatar"
                                            class="rounded-circle w-100 h-100 object-fit-cover d-flex align-items-center justify-content-center"
                                            style="margin-left:15px;">
                                        <span id="avatar-placeholder" class="fs-1">?</span>
                                    </div>
                                </div>
                                <h5 class="fw-bold">{{ $user->name }}</h5>
                                <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                    {{ $user->email_verified_at ? 'Подтвержден' : 'Не подтвержден' }}
                                </span>
                            </div>

                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title border-bottom pb-2 mb-3">
                                            <i class="fas fa-info-circle text-primary me-2"></i>Основная информация
                                        </h6>

                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <small class="text-muted">Имя</small>
                                                <p class="fw-bold mb-0">{{ $user->name }}</p>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <small class="text-muted">Email</small>
                                                <p class="fw-bold mb-0">
                                                    <i class="fas fa-envelope text-muted me-1"></i>
                                                    {{ $user->email }}
                                                </p>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <small class="text-muted">ID</small>
                                                <p class="fw-bold mb-0">#{{ $user->id }}</p>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <small class="text-muted">Статус</small>
                                                <p class="mb-0">
                                                    <span
                                                        class="badge bg-{{ $user->is_active ?? true ? 'success' : 'secondary' }}">
                                                        {{ $user->is_active ?? true ? 'Активен' : 'Неактивен' }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title border-bottom pb-2 mb-3">
                                            <i class="fas fa-calendar text-primary me-2"></i>Даты
                                        </h6>

                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted">Создан</small>
                                                <p class="fw-bold mb-0">{{ $user->created_at->format('d.m.Y') }}</p>
                                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                            </div>

                                            <div class="col-6">
                                                <small class="text-muted">Обновлен</small>
                                                <p class="fw-bold mb-0">{{ $user->updated_at->format('d.m.Y') }}</p>
                                                <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Редактировать
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-1"></i> Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection