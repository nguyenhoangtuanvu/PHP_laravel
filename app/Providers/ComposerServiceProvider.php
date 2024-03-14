<?php

namespace App\Providers;

use App\Composers\CartComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\View;
use App\Composers\CategoryComposer;
use App\Composers\CountCartCComposer;

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
        Facades\View::composer('*', CartComposer::class);
        Facades\View::composer('*', CountCartCComposer::class);
        // Facades\View::composer('clients.layouts.app',  CategoryComposer::class);
    }
}
