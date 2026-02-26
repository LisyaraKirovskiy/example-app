<?php

namespace App\Repository\Statistic;
use App\Models\Statistic;
use App\Http\Requests\StatisticStoreRequest;
use App\Models\Video;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use App\Repository\Statistic\StatisticRepositoryInterface;


class StatisticRepository implements StatisticRepositoryInterface
{
    public function store(StatisticStoreRequest $statisticStoreRequest, Video $video): void
    {
        $validated = $statisticStoreRequest->validated();
        DB::beginTransaction();
        try {
            $isLiked = $validated['like'] === 'true';
            $hasStat = Statistic::where('user_id', auth()->id())->where('video_id', $video->id)->first();

            if ($hasStat) {
                if ($hasStat->is_liked == $isLiked) {
                    $hasStat->delete();
                } else {
                    $hasStat->update(['is_liked' => $isLiked]);
                }
            } else {
                $newStat = Statistic::create([
                    'user_id' => auth()->id(),
                    'video_id' => $video->id,
                    'is_liked' => $isLiked,
                ]);
                $newStat->save();
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            throw new BadRequestException($exception->getMessage());
        }
    }
}