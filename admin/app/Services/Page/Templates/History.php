<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;

class History extends Template
{
    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'image' => elfinder($page->getData('image')),
            'description' => $page->getData('description'),
            'items' => $page->getData('items'),
        ]);
    }

    public function getCoumns() : array
    {
        return [
            //
        ];
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
                'name' => 'items',
                'label' => trans('admin.history'),
                'type' => 'repeatable',
                'fields' => [
                    [
                        'name' => 'year',
                        'label' => trans('admin.year'),
                        'type' => 'text',
                        'attributes' => [
                            'required' => true
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-sm-12 required'
                        ],
                    ],
                    [
                        'name' => 'event',
                        'label' => trans('admin.event'),
                        'type' => 'ckeditor',
                    ],
                ],
                'init_rows' => 0,
                'tab' => trans('admin.content')
            ],
        ];
    }

}
