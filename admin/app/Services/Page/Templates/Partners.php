<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;
use App\Models\Partner;
use App\Http\Resources\PartnerResource;

class Partners extends Template
{
    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'image' => elfinder($page->getData('image')),
            'description' => $page->getData('description'),
            'content' => $page->getData('content'),
            'partners' => Partner::active()->orderBy('lft')->get()->map(function($partner) {
                return new PartnerResource($partner);
            })
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
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans('admin.content'),
            ],
        ];
    }

}
