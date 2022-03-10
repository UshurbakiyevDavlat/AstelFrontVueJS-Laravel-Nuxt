<?php

namespace App\Common\Contracts;

interface Publishable
{

    public function scopeActive($query);
    public function scopeDraft($query);
    public static function getStatusOptions() : array;

    public function isActive() : bool;
    public function isDraft() : bool;
}
