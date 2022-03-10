<?php

namespace App\Common\Concerns;

trait PublishableTrait
{

    public function scopeActive($query)
    {
        $query->where('status', PUBLISHED);
    }

    public function scopeDraft($query)
    {
        $query->where('status', DRAFT);
    }

    public static function getStatusOptions() : array
    {
        return [
            PUBLISHED => trans('admin.published'),
            DRAFT => trans('admin.draft')
        ];
    }

    public function isActive() : bool
    {
        return $this->status == PUBLISHED;
    }

    public function isDraft() : bool
    {
        return $this->status == DRAFT;
    }


}
