<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;

class Charity extends Template
{
    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'image' => elfinder($page->getData('image')),
            'description' => $page->getData('description'),
            'content' => $page->getData('content'),
            'images' => elfinder($page->getData('images')),
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
            [
                'name' => 'images',
                'label' => trans('admin.images'),
                'type' => 'image',
                'multiple' => true,
                'tab' => trans('admin.content')
            ],
        ];
    }

}
