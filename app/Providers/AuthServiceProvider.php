<?php

namespace App\Providers;

use App\Models\User;
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
            return $user->isAdmin($user) || $user->isModerator($user) || $user->id == $targetUser->id;
        });

        Gate::define("delete-user", function (User $user): bool {
            return $user->isAdmin($user);
        });

        Gate::define("change-role", function (User $user): bool {
            return $user->isAdmin($user);
        });

        Gate::define("create-user", function (User $user): bool {
            return $user->isAdmin($user);
        });
    }
}
