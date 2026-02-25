<?php

namespace App\Repository\Video;
use App\Models\Video;
use App\Http\Requests\VideoStoreRequest;
use App\Http\Requests\VideoUpdateRequest;

interface VideoRepositoryInterface
{
    public function store(VideoStoreRequest $videoStoreRequest): Video;
    public function update(VideoUpdateRequest $videoUpdateRequest, Video $video): Video;
    public function destroy(Video $video): Video;
}