<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';
    
    public function boot(): void
    {
        Route::aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
    }
}