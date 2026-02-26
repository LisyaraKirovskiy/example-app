<?php

namespace App\Repository\Statistic;
use App\Http\Requests\StatisticStoreRequest;
use App\Models\Video;


interface StatisticRepositoryInterface
{
    public function store(StatisticStoreRequest $statisticStoreRequest, Video $video);
}