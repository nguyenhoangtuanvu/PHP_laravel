<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\View;
use App\Composers\CategoryComposer;

class ComposerServiceProvider extends ServiceProvider
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
        Facades\View::composer('*', CategoryComposer::class);
        // Facades\View::composer('clients.layouts.app',  CategoryComposer::class);
    }
}
