<?php

namespace App\Services\Page;

use Illuminate\Support\ServiceProvider;
use App\Services\Page\TemplateManager;

class PageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('template_manager', function($app) {
            return $app->make(TemplateManager::class);
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
