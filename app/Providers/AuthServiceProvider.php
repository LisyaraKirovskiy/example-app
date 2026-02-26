<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define("update-user", function (User $user, User $targetUser): bool {
            return $user->isAdmin() || $user->isModerator() || $user->id == $targetUser->id;
        });

        Gate::define("delete-user", function (User $user, User $targetUser): bool {
            return $user->isAdmin() || $user->id == $targetUser->id;
        });

        Gate::define("change-role", function (User $user): bool {
            return $user->isAdmin();
        });

        Gate::define("create-user", function (User $user): bool {
            return $user->isAdmin();
        });

        Gate::define("delete-video", function (User $user, Video $targetVideo): bool {
            return $user->isAdmin() || $user->isModerator() || $user->id == $targetVideo->user->id;
        });

        Gate::define("update-video", function (User $user, Video $targetVideo): bool {
            return $user->isAdmin() || $user->isModerator() || $user->id == $targetVideo->user_id;
        });

    }
}
