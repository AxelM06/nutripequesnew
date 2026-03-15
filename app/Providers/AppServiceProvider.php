<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
    $this->app->singleton('firebase.firestore', function ($app) {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase.json'));

        return $factory->createFirestore();
    });
   }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
