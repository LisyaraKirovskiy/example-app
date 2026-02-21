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
                    @can('create-user')
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Добавить пользователя
                        </a>
                    @endcan
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
                <form method="GET" action="{{ route('users.index') }}" class="p-3 border rounded">
                    <div class="row g-1 align-items-center">
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="name" placeholder="Имя"
                                value="{{ request('name') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="slug" placeholder="Slug"
                                value="{{ request('slug') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="email" placeholder="Email"
                                value="{{ request('email') }}">
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex align-items-center gap-1">
                                <span class="text-nowrap">от</span>
                                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                            </div>
                            <div class="d-flex align-items-center gap-1 mt-1">
                                <span class="text-nowrap">до</span>
                                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <select class="form-select" name="status">
                                <option value="">Статус</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }} name="active">
                                    Активен</option>
                                <option value="inactive" name="inactive">Неактивен</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100">Поиск</button>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary w-100">X</a>
                        </div>
                    </div>
                </form>
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Аватар</th>
                                    <th>Пользователь</th>
                                    <th>Slug</th>
                                    <th>Email</th>
                                    <th>Телефон</th>
                                    <th>Дата регистрации</th>
                                    <th>Роль</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr onclick="window.location='{{ route('users.show', $user) }}'">
                                        <td class="fw-bold">#{{ $user->id }}</td>
                                        <td>
                                            <div class="">
                                                <div class="rounded-circle bg-gradient d-flex align-items-center justify-content-center text-white fw-bold shadow-sm overflow-hidden"
                                                    style="width: 40px; height: 40px; background: #6366f1;">
                                                    <img id="avatar-preview" src="{{ $user->avatarPath() }}" alt="Avatar"
                                                        class="rounded-circle w-100 h-100 object-fit-cover"
                                                        style="margin-left:18px;">
                                                    <span id="avatar-placeholder" class="fs-1">?</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">

                                                <div>
                                                    <div class="fw-bold">{{ $user->name }}</div>
                                                    @if($user->active == true)
                                                        <small class="text-success">
                                                            <i class="fas fa-check-circle"></i> Активен
                                                        </small>
                                                    @else
                                                        <small class="text-danger">
                                                            <i class="fas fa-check-circle"></i> Не активен
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">

                                                <div>
                                                    <div class="fw-bold">{{ $user->slug }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fas fa-envelope text-muted me-1"></i>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    @foreach ($user->phones as $phone)
                                                        <div>{{ $phone->phoneBrand->name }} : {{ $phone->number }} </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-muted small">{{ $user->created_at->format('d.m.Y') }}</div>
                                            <small>{{ $user->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="@if($user->role->role == 'Admin') text-danger @elseif ($user->role->role == 'Moderator') text-primary @else text-muted @endif">
                                                    {{ $user->role->role ?? 'Нет роли'}}
                                                </div>
                                            </div>
                                        </td>
                                        @can('update-user', $user)
                                            <td>
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Редактировать</a>
                                            </td>
                                        @endcan
                                        @can('delete-user')
                                            <td>
                                                <form action="{{ route('users.destroy', $user) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Удалить</a>
                                                </form>
                                            </td>
                                        @endcan
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