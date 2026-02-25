@extends('layouts.app')
@section('title', 'Редактирование видео')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Редактирование видео</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('videos.update', $video) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Название видео</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $video->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                    name="description" rows="4">{{ old('description', $video->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="path" class="form-label">Ссылка на видео с Rutube</label>
                                <input type="text" class="form-control @error('path') is-invalid @enderror" id="path"
                                    name="path" value="{{ old('path', $video->path) }}" placeholder="например: 1234567"
                                    required>
                                <div class="form-text">Пример ссылки: https://rutube.ru/video/1345/</div>
                                @error('path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('users.show', $video->user) }}" class="btn btn-secondary">
                                    ← Назад
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Сохранить изменения
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection