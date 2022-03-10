<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;

use App\Models\Manager;
use App\Http\Resources\ManagerResource;

class Team extends Template
{
    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'image' => elfinder($page->getData('image')),
            'description' => $page->getData('description'),
            'managers' => Manager::active()->orderBy('lft')->get()->map(function($manager) {
                return new ManagerResource($manager);
            }),
        ]);
    }

    public function getColumns() : array
    {
        return [];
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
        ];
    }

}
