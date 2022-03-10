<?php

namespace App\Services\Page\Concerns;

use TemplateManager;

trait HasTemplate
{

    public static function getTemplateOptions() : array
    {
        return TemplateManager::getTemplates();
    }


    public function getTemplate()
    {
        return TemplateManager::getTemplate($this->template);
    }

    public function scopeMenu($query)
    {
        $query->whereIn('template', TemplateManager::getMenuTemplates());
    }

    public function prepare()
    {
        return $this->getTemplate()->prepare($this);
    }

    public function prepareRelated($related)
    {
        return $this->getTemplate()->prepareRelated($this, $related);
    }

}
