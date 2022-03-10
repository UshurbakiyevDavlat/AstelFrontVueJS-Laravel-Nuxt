<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use TemplateManager;
use App\Services\Page\Models\Page;

class PageSeeder extends Seeder
{

    public function run()
    {

        $templates = TemplateManager::getTemplates();

        $about = Page::firstOrCreate([
            'template' => 'about',
        ], [
            'name' => trans('templates.about'),
            'slug' => 'about'
        ]);
        $about_childs = ['history', 'team', 'vacancies', 'certificates', 'partners', 'charity'];

        foreach($templates as $key => $name) {
            Page::firstOrCreate([
                'template' => $key,
            ], [
                'name' => $name,
                'slug' => $key,
                'parent_id' => in_array($key, $about_childs) ? $about->id : null
            ]);
        }

    }
}
