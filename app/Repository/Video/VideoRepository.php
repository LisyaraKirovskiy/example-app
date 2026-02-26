<?php

namespace App\Repository\Video;
use App\Models\Video;
use App\Http\Requests\VideoStoreRequest;
use App\Http\Requests\VideoUpdateRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use App\Repository\Video\VideoRepositoryInterface;


class VideoRepository implements VideoRepositoryInterface
{
    public function store(VideoStoreRequest $videoStoreRequest): Video
    {

        $validated = $videoStoreRequest->validated();
        DB::beginTransaction();
        try {
            $newVideo = Video::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'path' => str_contains($validated['path'], 'embed') ? explode('/', $validated['path'])[5] : explode('/', $validated['path'])[4],
                'user_id' => auth()->id(),
            ]);

            $newVideo->save();
            DB::commit();
            return $newVideo;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            throw new BadRequestException($exception->getMessage());
        }
    }

    public function update(VideoUpdateRequest $videoUpdateRequest, Video $video): Video
    {
        $validated = $videoUpdateRequest->validated();
        if ($validated['path'] != $video->path) {
            $validatedPath = str_contains($validated['path'], 'embed') ? explode('/', $validated['path'])[5] : explode('/', $validated['path'])[4];
        } else {
            $validatedPath = $validated['path'];
        }
        ;
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name'],
                'description' => $validated['description'],
                'path' => $validatedPath,
            ];

            $video->update($updateData);
            DB::commit();

            return $video;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            throw new BadRequestException($exception->getMessage());
        }

    }
    public function destroy(Video $video): Video
    {
        DB::beginTransaction();
        try {
            $video->delete($video->id);
            DB::commit();
            return $video;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            throw new BadRequestException($exception->getMessage());
        }
    }
}