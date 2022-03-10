<?php

namespace App\Services\Page;

use App\Services\Page\Concerns\HasCRUD;
use App\Services\Page\Models\Page;
use App\Services\Page\Contracts\HasInnerPage;

class Template
{
    use HasCRUD;

    public function prepare(Page $page) : array
    {
        $translations = [];
        foreach($page->translations()->wherePivot('level', 0)->get() as $translation) {
            $translations[$translation->hash] = $translation->translation;
        }

        return array_merge($page->simple(), [
            'component' => $this->key(),
            'translations' => $translations
        ], $page->getSeoTags());
    }

    public function prepareRelated(Page $page, $slug) : array
    {
        if (!$this->hasInnerPage()) {
            abort(404);
        }

        $translations = [];
        foreach($page->translations()->wherePivot('level', 1)->get() as $translation) {
            $translations[$translation->hash] = $translation->translation;
        }

        return array_merge($page->simple(), [
            'component' => $this->key() . '-inner',
            'translations' => $translations
        ]);
    }

    public function menu() : bool
    {
        return true;
    }

    public function key() : string
    {
        return lcfirst(class_basename(static::class));
    }

    public function hasInnerPage() : bool
    {
        return $this instanceOf HasInnerPage;
    }


}
