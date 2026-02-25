@extends('layouts.app')
@section('title', 'Профиль: ' . $user->name)

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8" style="max-width: 100%;">
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
                                        style="width: 80px; height: 80px; background: #6366f1; margin-left: 150px;"
                                        id="circle">
                                        <img id="avatar" src="{{ asset($user->avatarPath()) }}" alt="Avatar"
                                            class="rounded-circle w-100 h-100 object-fit-cover d-flex align-items-center justify-content-center"
                                            style="margin-left:15px;">
                                        <span id="avatar-placeholder" class="fs-1">?</span>
                                    </div>
                                </div>
                                <h4 class="fw-bold mt-4">{{ $user->name }}</h4>
                                @foreach ($user->phones as $phone)
                                    <div>{{ $phone->phoneBrand->name }} : {{ $phone->number }} </div>
                                @endforeach
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
                                                <small class="text-muted">Slug</small>
                                                <p class="fw-bold mb-0">{{ $user->slug }}</p>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <small class="text-muted">Роль</small>
                                                <p class="fw-bold mb-0">{{ $user->role->role }}</p>
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

                        <div class="d-flex justify-content-between mt-4 pt-3">
                            @can('update-user', $user)
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                                    Редактировать
                                </a>
                            @endcan
                            @can('delete-user')
                                <form action="{{ route('users.destroy', $user) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">
                                        Удалить
                                    </button>
                                </form>
                            @endcan
                        </div>
                        <div class="border-top pt-3 mt-3">
                            <div class="row g-3">
                                @foreach ($videos as $video)
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="text-center mb-0 ">
                                            <a href="{{ route('videos.show', $video) }}"
                                                class="d-inline-block px-3 py-1 rounded"
                                                style="text-decoration: none; background-color: rgb(13, 110, 253); color: white; font-family: Calibri; max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                {{ $video->name }}
                                            </a>
                                        </div>
                                        <iframe width="100%" height="200" src={{ "https://rutube.ru/play/embed/" . $video->path }} style="border: none;" allow="clipboard-write;" webkitAllowFullScreen
                                            mozallowfullscreen allowFullScreen></iframe>

                                        <div class="d-flex flex-row" style="width:100%;">
                                            @can('update-video', $video)
                                                <a class="btn btn-primary" href="{{ route('videos.edit', $video) }}"
                                                    style="width:50%;">Редактировать</a>
                                            @endcan
                                            @can('delete-video', $video)
                                                <form action="{{ route('videos.destroy', $video) }}" style="width:50%;"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit"
                                                        style="width:100%;">Удалить</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $videos->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection