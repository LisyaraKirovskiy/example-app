@extends('layouts.app')
@section('title', 'Редактировать пользователя')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-edit me-2"></i>Редактировать пользователя
                            </h4>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-light">
                                ← Назад
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h5>Ошибки:</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Имя <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                    placeholder="Введите имя" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" placeholder="email@example.com" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Новый пароль</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Оставьте пустым, если не меняете">
                                <small class="text-muted">Минимум 8 символов</small>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Подтверждение пароля</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Повторите новый пароль">
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                                    Отмена
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i> Сохранить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection