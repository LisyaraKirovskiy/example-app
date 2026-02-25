<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Statistic extends Model
{
    /**
     * 
     * @property bool $is_liked
     * @property int $user_id
     * @property int $video_id
     * 
     */
    protected $fillable = [
        'is_liked',
        'user_id',
        'video_id',
    ];

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}