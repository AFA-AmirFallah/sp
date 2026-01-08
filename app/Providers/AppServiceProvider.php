<?php

namespace App\Providers;

use App\myappenv;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (myappenv::httpsforce) {
            if (app()->environment('remote')) {
                URL::forceScheme('https');
            }
        }
    }
}
