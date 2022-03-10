<?php

namespace App\Repositories;

use App\Services\Settings\Models\Settings;

class SettingsRepository extends Repository
{

    public function getMap() : array
    {
        $settings = [];

        foreach(Settings::active()->get() as $item) {
            $settings[$item->key] = $item->value;
        }

        return $settings;
    }

}
