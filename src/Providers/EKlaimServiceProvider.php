<?php

namespace FaisalHalim\LaravelEklaimApi\Providers;

use Illuminate\Support\ServiceProvider;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;
use FaisalHalim\LaravelEklaimApi\Helpers\EKlaimCrypt;

class EKlaimServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * 
     * @return void
     * */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->publishes([
            __DIR__ . '/../Config/eklaim.php' => config_path('eklaim.php'),
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

        // $this->app->singleton(EklaimService::class, function ($app) {
        //     return new EklaimService(
        //         config('eklaim.api_url'),
        //         config('eklaim.secret_key'),
        //         new EKlaimCrypt()
        //     );
        // });

        EklaimService::configure(
            config('eklaim.api_url'),
            config('eklaim.secret_key'),
            $this->app->make(EKlaimCrypt::class)
        );
    }
}
