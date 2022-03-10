<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController as OriginalCrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class CrudController extends OriginalCrudController
{

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        CRUD::set('show.setFromDb', false);
        $this->setupListOperation();
    }

    protected function setupReorderOperation()
    {
        CRUD::set('reorder.label', 'name');
        CRUD::set('reorder.max_level', 1);
    }

    protected function addSeoColumns()
    {
        CRUD::addColumns([
            [
                'name' => 'slug',
                'label' => trans('admin.slug'),
            ],
            [
                'name' => 'seo_title',
                'label' => trans('admin.seo_title'),
                'fake' => true,
                'store_in' => 'seo',
            ],
            [
                'name' => 'seo_image',
                'label' => trans('admin.seo_image'),
                'type' => 'image',
                'width' => '80px',
                'height' => 'auto',
                'disk' => 'elfinder',
                'fake' => true,
                'store_in' => 'seo',
            ],
            [
                'name' => 'seo_description',
                'label' => trans('admin.seo_description'),
                'type' => 'markdown',
                'fake' => true,
                'store_in' => 'seo',
            ],
            [
                'name' => 'seo_keywords',
                'label' => trans('admin.seo_keywords'),
                'type' => 'markdown',
                'fake' => true,
                'store_in' => 'seo',
            ],
        ]);
    }

    protected function addSeoFields()
    {
        CRUD::addFields([
            [
                'name' => 'slug',
                'label' => trans('admin.slug'),
                'hint' => trans('admin.slug_hint'),
                'tab' => trans('admin.seo'),
            ],
            [
                'name' => 'seo_title',
                'label' => trans('admin.seo_title'),
                'type' => 'text',
                'fake' => true,
                'store_in' => 'seo',
                'tab' => trans('admin.seo'),
            ],
            [
                'name' => 'seo_description',
                'label' => trans('admin.seo_description'),
                'type' => 'textarea',
                'fake' => true,
                'store_in' => 'seo',
                'tab' => trans('admin.seo'),
            ],
            [
                'name' => 'seo_keywords',
                'label' => trans('admin.seo_keywords'),
                'type' => 'textarea',
                'fake' => true,
                'store_in' => 'seo',
                'hint' => trans('admin.seo_keywords_hint'),
                'tab' => trans('admin.seo'),
            ],
            [
                'name' => 'seo_image',
                'label' => trans('admin.seo_image'),
                'type' => 'image',
                'fake' => true,
                'store_in' => 'seo',
                'tab' => trans('admin.seo'),
            ],
        ]);
    }

}
