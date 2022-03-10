<?php

namespace App\Services\Page\Concerns;

use App\Services\Page\Concerns;

trait HasCRUD
{
    use HasSeo;

    public function getFields() : array
    {
        return [
            [
                'name' => 'title',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ]
        ];
    }

    public function getColumns() : array
    {
        return [
            [
                'name' => 'title',
                'label' => trans('admin.title')
            ],
        ];
    }

    public function getAllFields() : array
    {
        return array_merge(
            array_map(function($field) {
                $field['fake'] = true;
                $field['store_in'] = 'data';
                return $field;
            }, $this->getFields()),
            method_exists($this, 'hasSeoTags') && $this->hasSeoTags() ? $this->getSeoFields() : []
        );
    }

    public function getAllColumns() : array
    {
        return array_merge(
            array_map(function($column) {
                $column['fake'] = true;
                $column['store_in'] = 'data';
                return $column;
            }, $this->getColumns()),
            method_exists($this, 'hasSeoTags') && $this->hasSeoTags() ? $this->getSeoColumns() : []
        );
    }

}
