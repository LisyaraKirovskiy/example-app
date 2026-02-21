<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Filter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 *@property string $name
 *@property string $email
 *@property string $password
 *@property Carbon $created_at
 *@property string $slug
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Filter;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'slug',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function avatar(): HasOne
    {
        return $this->hasOne(Avatar::class);
    }

    public function avatarPath(): ?string
    {
        if ($this->avatar) {
            $folderPath = $this->created_at->format('Y/m');
            return 'storage/' . $folderPath . '/' . $this->avatar->path;
        } else {
            return asset('storage/Default/default.jpg');
        }
    }

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function isAdmin(User $user): bool
    {
        return $user->role->role == 'Admin';
    }

    public function isModerator(User $user): bool
    {
        return $user->role->role == 'Moderator';
    }
}
