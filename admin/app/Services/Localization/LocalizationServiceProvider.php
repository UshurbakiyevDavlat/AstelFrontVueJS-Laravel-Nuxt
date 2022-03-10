<?php

namespace App\Services\Localization;

use Illuminate\Support\ServiceProvider;
use App\Services\Localization\Localization;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('localization', function($app) {
            return $app->make(Localization::class);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
