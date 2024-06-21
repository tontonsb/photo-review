<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('comment', fn(User $user) => $user->verified_at);
        Gate::define('view-comment-authors', fn(User $user) => $user->verified_at);
        Gate::define('view-user-names', fn(User $user) => $user->verified_at);
    }
}
