<?php

namespace Mostafax\Knet;

use Illuminate\Support\ServiceProvider;

class KnetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        include __DIR__.'/routes/web.php'; 
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/views', 'knet');
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/knet'),
        ]);
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations/knet'),
        ], 'migrations'); 
    }


   
}
