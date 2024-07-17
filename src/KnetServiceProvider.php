<?php

namespace Mostafax\Knet;

use Illuminate\Support\ServiceProvider;
use Mostafax\Knet\Services\knet;
use Mostafax\Knet\Repositories\PaymentRepository;
use Mostafax\Knet\Models\Payment;

class KnetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        include __DIR__.'/routes/web.php'; 
        $this->app->singleton(knet::class, function ($app) {
            return new knet();
        });
        $this->app->bind(PaymentRepository::class, function ($app) {
            return new PaymentRepository(new Payment());
        });
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/views', 'knet');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations'); 
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/knet'),
        ]);
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations/knet'),
        ], 'migrations');
        $this->publishes([
            __DIR__.'/Requests' => app_path('Http/Requests/knet'),
        ], 'KnetRequest'); 
        
    }


   
}
