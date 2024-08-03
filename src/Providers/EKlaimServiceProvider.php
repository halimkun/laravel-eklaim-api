<?php

namespace FaisalHalim\LaravelEklaimApi\Providers;

use Illuminate\Support\ServiceProvider;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;
use FaisalHalim\LaravelEklaimApi\Helpers\EKlaimCrypt;
use Illuminate\Support\Facades\Artisan;

class EKlaimServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * 
     * @return void
     * */
    public function boot()
    {
        // Register the EKlaimPublish command
        $this->commands([
            \FaisalHalim\LaravelEklaimApi\Commands\EKlaimPublish::class,
        ]);
    }

    /**
     * Register the application services.
     * 
     * @return void
     * */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/eklaim.php', 'eklaim');

        $this->app->singleton(EKlaimCrypt::class, function ($app) {
            return new EKlaimCrypt();
        });

        // Configure the EKlaimService
        EklaimService::configure(
            config('eklaim.api_url'),
            config('eklaim.secret_key'),
            $this->app->make(EKlaimCrypt::class)
        );

        // Register the EKlaimPublish command
        $this->commands([
            \FaisalHalim\LaravelEklaimApi\Commands\EKlaimPublish::class,
        ]);
    }
}
