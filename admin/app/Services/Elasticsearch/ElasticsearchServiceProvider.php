<?php

namespace App\Services\Elasticsearch;

use Illuminate\Support\ServiceProvider;

use App\Services\Elasticsearch\Console\Commands\CreateIndex;
use App\Services\Elasticsearch\Console\Commands\DropIndex;
use App\Services\Elasticsearch\Console\Commands\MigrateIndex;

class ElasticsearchServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('elasticsearch_service', function($app) {
            return $app->make(ElasticsearchService::class);
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateIndex::class,
                DropIndex::class,
            ]);
        }
    }

}
