<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    /**
     * 
     * @property string $name
     * @property string $description
     * @property string $path
     * @property int $views
     * @property int $user_id
     */
    protected $fillable = [
        'name',
        'description',
        'path',
        'views',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(Statistic::class);
    }

}