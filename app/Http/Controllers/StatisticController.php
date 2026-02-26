<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatisticStoreRequest;
use App\Models\Video;
use App\Repository\Statistic\StatisticRepository;
use Illuminate\Http\RedirectResponse;

class StatisticController extends Controller
{

    public function __construct(private readonly StatisticRepository $statisticRepository)
    {
    }
    public function store(StatisticStoreRequest $statisticStoreRequest): RedirectResponse
    {
        $video = Video::findOrFail($statisticStoreRequest->video_id);
        $this->statisticRepository->store($statisticStoreRequest, $video);
        return redirect()->back();
    }
}
