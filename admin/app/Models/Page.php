<?php

namespace App\Models;

use App\Services\Page\Models\Page as OriginalPage;

use App\Services\Elasticsearch\Contracts\Searchable;
use App\Services\Elasticsearch\Concerns\Searchable as SearchableTrait;

class Page extends OriginalPage implements Searchable
{
    use SearchableTrait;

    public function toElastic() : array
    {
        return [
            'name' => implodeToString($this->getTranslations('name')),
            'slug' => $this->slug,
            'data' => implodeToString($this->getTranslations('data')),
            'seo' => implodeToString($this->getTranslations('seo')),
        ];
    }

    public function getElasticTitle() : string
    {
        return $this->name;
    }

    public function getElasticDescription() : string
    {
        return '';
    }

    public function getElasticTemplate()
    {
        return $this->template;
    }

    public function getElasticSlug()
    {
        return null;
    }

    public function shouldIndex() : bool
    {
        if ($this->template == 'search') {
            return false;
        }

        if ($this instanceof Publishable) {
            return $this->isActive();
        }

        return true;
    }

}
