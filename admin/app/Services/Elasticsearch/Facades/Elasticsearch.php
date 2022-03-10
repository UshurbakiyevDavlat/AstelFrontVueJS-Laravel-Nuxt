<?php

namespace App\Services\Elasticsearch\Facades;

use Illuminate\Support\Facades\Facade;

class Elasticsearch extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'elasticsearch_service';
    }
}
