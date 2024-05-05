<?php

namespace App\Providers;

use App\Services\ReviewableService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ReviewableService::class,
            fn() => new ReviewableService(Storage::disk('reviewables'))
        );
    }
}
