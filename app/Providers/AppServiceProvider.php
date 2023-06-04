<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        //
        Blade::aliascomponent('components.badge', 'badge');
        Blade::aliascomponent('components.updated', 'updated');
        Blade::aliascomponent('components.tag', 'tag');
        Blade::aliascomponent('components.card', 'card');
    }
}
