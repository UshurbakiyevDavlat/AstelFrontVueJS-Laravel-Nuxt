<?php

namespace App\Common\Concerns;

use Cviebrock\EloquentSluggable\Sluggable;

trait SluggableTrait
{
    use Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function scopeFindBySlugOrFail($query, $slug)
    {
        return $query->where('slug', $slug)->firstOrFail();
    }

    public function getFullSlug() : string
    {
        return $this->slug;
    }
}
