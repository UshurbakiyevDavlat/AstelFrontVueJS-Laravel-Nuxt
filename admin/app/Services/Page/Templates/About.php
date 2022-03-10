<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;

class About extends Template
{
    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'title' => $page->getData('title'),
            'description' => $page->getData('description'),
            'image' => elfinder($page->getData('image')),
            'about' => $page->getData('about'),
            'mission' => $page->getData('mission'),
            'partner_title' => $page->getData('partner_title'),
            'partner_image' => elfinder($page->getData('partner_image')),
            'partner_items' => $page->getData('partner_items'),
            'company_title' => $page->getData('company_title'),
            'content' => $page->getData('content'),
            'documents' => array_map(function($document) {
                $document->file = elfinder($document->file);
                return $document;
            }, array_filter($page->getData('documents') ?? [])),
        ]);
    }

    public function getFields() : array
    {
        return [
            [
                'name' => 'title',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
                'type' => 'textarea',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'image',
                'label' => trans('admin.image'),
                'type' => 'image',
                'tab' => trans('admin.main')
            ],
            [
                'name' => 'about',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans('admin.about'),
            ],
            [
                'name' => 'mission',
                'label' => trans('admin.mission'),
                'type' => 'ckeditor',
                'tab' => trans('admin.about'),
            ],
            [
                'name' => 'partner_image',
                'label' => trans('admin.image'),
                'type' => 'image',
                'tab' => trans('admin.partnership'),
            ],
            [
                'name' => 'partner_title',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans('admin.partnership'),
            ],
            [
                'name' => 'partner_items',
                'label' => trans('admin.partner_items'),
                'type' => 'repeatable',
                'init_rows' => 0,
                'fields' => [
                    [
                        'name' => 'description',
                        'label' => '',
                        'type' => 'textarea',
                    ],
                ],
                'tab' => trans('admin.partnership'),
            ],
            [
                'name' => 'company_title',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans('admin.company'),
            ],
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans('admin.company'),
            ],
            [
                'name' => 'documents',
                'label' => trans('admin.documents'),
                'type' => 'repeatable',
                'init_rows' => 0,
                'fields' => [
                    [
                        'name' => 'file',
                        'label' => trans('admin.file'),
                        'type' => 'browse',
                    ],
                    [
                        'name' => 'name',
                        'label' => trans('admin.name'),
                        'type' => 'text',
                    ],
                ],
                'sortable' => true,
                'tab' => trans('admin.documents'),
            ],
        ];
    }

}
