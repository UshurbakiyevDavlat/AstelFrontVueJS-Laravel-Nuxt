<?php

namespace App\Services\Page;

class TemplateManager
{

    protected $templates = [];
    protected $menuTemplates = [];

    public function __construct()
    {
        $files = glob(__DIR__.'/Templates/*.php');

        foreach($files as $file) {
            $template = $this->getTemplate(basename($file, '.php'));
            $key = $template->key();

            if ($template->menu()) {
                $this->menuTemplates[] = $key;
            }
            $this->templates[$key] = trans("templates.{$key}");
        }

    }

    public function getTemplates() : array
    {
        return $this->templates;
    }

    public function getMenuTemplates() : array
    {
        return $this->menuTemplates;
    }

    public function getTemplate(string $template = null)
    {
        if (!$template) {
            return new Template;
        }
        $class = __NAMESPACE__ . '\Templates\\' . ucfirst($template);
        return app()->make($class);
    }

}
