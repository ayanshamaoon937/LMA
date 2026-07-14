<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $files = glob(app_path('Helpers') . "/*.php");
        foreach ($files as $key => $file) {
            require_once $file;
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!request()->is('admin*') && !request()->is('filament*')) {
         URL::defaults(['locale' => config('app.locale', 'en')]);
        }
    }
}
