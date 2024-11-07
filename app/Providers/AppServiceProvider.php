<?php

namespace App\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Manually bind the 'files' service to the container
        /*$this->app->singleton('files', function ($app) {
            return new Filesystem();
        });*/
        //ignore the routes registered by Passport
        Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::loadKeysFrom(storage_path('secrets'));
        Passport::hashClientSecrets();

        Passport::tokensCan([
            'place-orders' => 'Place orders',
            'read' => 'Readl all',
        ]);
    }
}
