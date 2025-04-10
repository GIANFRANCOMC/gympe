<?php

namespace App\Providers;

use App\View\Components\System\{SystemGuestLayout};
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('system-guest-layout', SystemGuestLayout::class);
    }
}
