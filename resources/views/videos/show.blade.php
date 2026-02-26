@extends('layouts.app')
@section('title', 'Просмотр видео')

@section('content')
    <div class="container mt-4">

        <div class="mb-3">
            <iframe width="1280" height="720" src={{ "https://rutube.ru/play/embed/" . $video->path . "?autoStart=true" }}
                style="border: none;" allow="clipboard-write;" webkitAllowFullScreen mozallowfullscreen
                allowFullScreen></iframe>
        </div>

        <h2>{{ $video->name }}</h2>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted">
                <span class="me-3">{{ number_format($video->views) }} просмотров</span>
                <span>{{ $video->created_at->format('d.m.Y') }}</span>
            </div>

            <form method="post" action="{{ route('statistics.store') }}">
                @csrf
                <input type="hidden" name="video_id" value="{{ $video->id }}">
                <button type="submit" class="btn btn-outline-success btn-md me-1" name="like" value="true">
                    👍{{ $video->likesCount() }}
                </button>
                <button type=" submit" class="btn btn-outline-danger btn-md" name="like" value="false">
                    👎{{ $video->dislikesCount() }}
                </button>
            </form>
        </div>
        <form action="{{ route('users.show', $video->user) }}"
            class="d-flex flex-column align-items-start p-0 bg-light rounded text-center">
            <button class="d-flex flex-row border-0 bg-light align-items-center">
                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3"
                    style="width: 40px; height: 40px;">
                    {{ substr($video->user->name, 0, 1) }}
                </div>
                <div class="d-flex flex-column">
                    <h6 class="mb-0">{{ $video->user->name }}</h6>
                    <small class="text-muted">Автор видео</small>
                </div>
            </button>
        </form>

        @if($video->description)
            <div class="mt-3 p-0 bg-light rounded">
                <p class="mb-0"><span class="text-muted">Описание: </span>{{ $video->description }}</p>
            </div>
        @endif
    </div>




@endsection