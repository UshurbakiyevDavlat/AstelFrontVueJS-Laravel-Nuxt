<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;

use App\Models\Vacancy;
use App\Http\Resources\VacancyResource;

class Vacancies extends Template
{
    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'image' => elfinder($page->getData('image')),
            'description' => $page->getData('description'),
            'content' => $page->getData('content'),
            'vacancies' => Vacancy::active()->orderBy('lft')->get()->map(function($vacancy) {
                return new VacancyResource($vacancy);
            })
        ]);
    }

    public function getFields() : array
    {
        return [
            [
                'name' => 'image',
                'label' => trans('admin.image'),
                'type' => 'image',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
                'type' => 'textarea',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans('admin.content'),
            ],
        ];
    }

}
