<?php

namespace App\Services\Page\Concerns;

trait HasSeo
{

    public function hasSeoTags() : bool
    {
        return true;
    }

    public function getSeoColumns() : array
    {
        return array_map(function($column) {
            $column['fake'] = true;
            $column['store_in'] = 'seo';
            return $column;
        }, [
            [
                'name' => 'seo_title',
                'label' => trans('admin.seo_title'),
            ],
            [
                'name' => 'seo_image',
                'label' => trans('admin.seo_image'),
                'type' => 'image',
                'width' => '150px',
                'height' => 'auto',
                'disk' => 'elfinder',
            ],
            [
                'name' => 'seo_description',
                'label' => trans('admin.seo_description'),
                'type' => 'markdown',
            ],
            [
                'name' => 'seo_keywords',
                'label' => trans('admin.seo_keywords'),
                'type' => 'markdown',
            ],
        ]);
    }

    public function getSeoFields() : array
    {
        return array_map(function($field) {
            $field['fake'] = true;
            $field['store_in'] = 'seo';
            return $field;
        }, [
            [
                'name' => 'seo_title',
                'label' => trans('admin.seo_title'),
                'type' => 'text',
                'tab' => trans('admin.seo'),
            ],
            [
                'name' => 'seo_description',
                'label' => trans('admin.seo_description'),
                'type' => 'textarea',
                'tab' => trans('admin.seo'),
            ],
            [
                'name' => 'seo_keywords',
                'label' => trans('admin.seo_keywords'),
                'type' => 'textarea',
                'hint' => trans('admin.seo_keywords_hint'),
                'tab' => trans('admin.seo'),
            ],
            [
                'name' => 'seo_image',
                'label' => trans('admin.seo_image'),
                'type' => 'image',
                'tab' => trans('admin.seo'),
            ],
        ]);
    }

}
