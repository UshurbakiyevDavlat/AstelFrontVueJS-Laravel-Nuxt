<?php

namespace App\Services\Page\Facades;

use Illuminate\Support\Facades\Facade;


class TemplateManager extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'template_manager';
    }

}
