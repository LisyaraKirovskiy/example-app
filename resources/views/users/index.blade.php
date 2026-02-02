@extends('layouts.app')
@section('title', 'Список пользователей')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3">
                        <i class="fas fa-users text-primary me-2"></i>Пользователи
                    </h1>
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Добавить пользователя
                    </a>
                </div>
                <p class="text-muted mb-0">Всего пользователей: {{ $users->total() }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Пользователь</th>
                                    <th>Email</th>
                                    <th>Дата регистрации</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="fw-bold">#{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-3">
                                                    <div class="avatar-initials fw-bold text-white rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px; background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $user->name }}</div>
                                                    @if($user->email_verified_at)
                                                        <small class="text-success">
                                                            <i class="fas fa-check-circle"></i> Подтвержден
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fas fa-envelope text-muted me-1"></i>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            <div class="text-muted small">{{ $user->created_at->format('d.m.Y') }}</div>
                                            <small>{{ $user->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Редактировать</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('users.destroy', $user) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Удалить</a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Пагинация -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Показано {{ $users->firstItem() }} - {{ $users->lastItem() }} из {{ $users->total() }}
                        </div>
                        <div>
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-users fa-3x text-muted"></i>
                        </div>
                        <h4 class="text-muted">Пользователи не найдены</h4>
                        @if(request('search') || request('status'))
                            <p class="text-muted">Попробуйте изменить параметры поиска</p>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
                                Сбросить фильтры
                            </a>
                        @else
                            <p class="text-muted">Создайте первого пользователя</p>
                            <a href="{{ route('users.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Добавить пользователя
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection