<?php

namespace App\Common\Concerns;

use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;

trait TranslatableTrait
{
    use HasTranslations;

    public $translatable = [];

}
