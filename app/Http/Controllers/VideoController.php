<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoStoreRequest;
use App\Http\Requests\VideoUpdateRequest;
use App\Models\Video;
use App\Repository\Video\VideoRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class VideoController extends Controller
{
    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }
    public function create(): View
    {
        return view("videos.create");
    }

    public function store(VideoStoreRequest $videoStoreRequest): RedirectResponse
    {
        $this->videoRepository->store($videoStoreRequest);
        return redirect()->back()->with("success", "Видео успешно добавлено!");
    }

    public function show(Video $video): View
    {
        return view('videos.show', ['video' => $video]);
    }

    public function edit(Video $video): View
    {
        $this->authorize('update-video', $video);
        return view('videos.edit', ['video' => $video]);
    }

    public function update(VideoUpdateRequest $videoUpdateRequest, Video $video): RedirectResponse
    {
        $this->authorize('update-video', $video);
        $this->videoRepository->update($videoUpdateRequest, $video);
        return redirect()->route('users.show', $video->user)->with("success", "Видео успешно обновлено!");
    }

    public function destroy(Video $video): RedirectResponse
    {
        $this->authorize('delete-video');
        $this->videoRepository->destroy($video);
        return redirect()->route('users.show', $video->user)->with("success", "Видео успешно удалено!");
    }
}
