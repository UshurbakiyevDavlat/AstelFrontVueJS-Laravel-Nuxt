<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;

use App\Models\License;
use App\Models\Certificate;
use App\Http\Resources\LicenseResource;
use App\Http\Resources\CertificateResource;

class Certificates extends Template
{

    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'image' => elfinder($page->getData('image')),
            'description' => $page->getData('description'),
            'license_content' => $page->getData('license_content'),
            'certificate_content' => $page->getData('certificate_content'),
            'licenses' => License::active()->orderBy('lft')->get()->map(function($item){
                return new LicenseResource($item);
            }),
            'certificates' => Certificate::active()->orderBy('lft')->get()->map(function($item){
                return new CertificateResource($item);
            }),
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
                'name' => 'license_content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans_choice('admin.licenses', 2)
            ],
            [
                'name' => 'certificate_content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans_choice('admin.certificates', 2),
            ],
        ];
    }

}
