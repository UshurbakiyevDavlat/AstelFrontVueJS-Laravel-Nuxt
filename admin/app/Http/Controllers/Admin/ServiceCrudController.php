<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ServiceRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Service;

class ServiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public function setup()
    {
        CRUD::setModel(Service::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/service');
        CRUD::setEntityNameStrings(trans_choice('admin.services', 1), trans_choice('admin.services', 2));
    }

    protected function setupListOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'check',
            ],
            [
                'name' => 'image',
                'label' => trans('admin.image'),
                'type' => 'icon',
                'disk' => 'elfinder',
                'width' => '50px',
                'height' => 'auto',
            ],
            [
                'name' => 'updated_at',
                'label' => trans('admin.updated_at'),
                'type' => 'datetime',
            ],
            [
                'name' => 'created_at',
                'label' => trans('admin.created_at'),
                'type' => 'datetime',
            ],
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'markdown',
            ],
        ]);

        $this->addSeoColumns();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ServiceRequest::class);

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
                'type' => 'text',
                'attributes' => [
                    'required' => true,
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12 required'
                ],
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select2_from_array',
                'options' => Service::getStatusOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-5'
                ],
            ],
            [
                'name' => 'parent_id',
                'label' => trans('admin.parent'),
                'type' => 'select2',
                'entity' => 'parentService',
                'model' => \App\Models\Service::class,
                'attribute' => 'name',
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-7'
                ],
            ],
            [
                'name' => 'image',
                'label' => trans('admin.image'),
                'type' => 'select2_from_array_icons',
                'options' => Service::getIcons(),
                'wrapperAttributes' => [
                    'class' => 'col-lg-3 col-xl-2 with-icon'
                ],
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'ImageForServices',
                'label' => trans('admin.image'),
                'type'  => 'browse',
                'fake' => true,
                'store_in' => 'docs',
                'tab' => trans('admin.documents'),
            ],
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans('admin.content'),
            ],
            [
                'name' => 'advantages_title',
                'label' => trans('admin.title'),
                'type' => 'text',
                'fake' => true,
                'store_in' => 'data',
                'tab' => trans('admin.advantages'),
            ],
            [
                'name' => 'advantages',
                'label' => trans('admin.advantages'),
                'type' => 'repeatable',
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => trans('admin.image'),
                        'type' => 'image',
                    ],
                    [
                        'name' => 'name',
                        'label' => '',
                        'type' => 'text',
                    ],
                ],
                'fake' => true,
                'store_in' => 'data',
                'tab' => trans('admin.advantages'),
            ],
            [
                'name' => 'connection_title',
                'label' => trans('admin.title'),
                'type' => 'text',
                'fake' => true,
                'store_in' => 'data',
                'tab' => trans('admin.connection'),
            ],
            [
                'name' => 'connection_content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'fake' => true,
                'store_in' => 'data',
                'tab' => trans('admin.connection'),
            ],
            [
                'name' => 'connection_items',
                'label' => trans('admin.advantages'),
                'type' => 'table',
                'columns' => [
                    'name' => ''
                ],
                'fake' => true,
                'store_in' => 'data',
                'tab' => trans('admin.connection'),
            ],
            [
                'name' => 'documents',
                'label' => trans('admin.documents'),
                'type' => 'repeatable',
                'fields' => [
                    [
                        'name' => 'name',
                        'label' => trans('admin.name'),
                        'type' => 'text',
                    ],
                    [   // Browse
                        'name'  => 'path',
                        'label' => 'Файл',
                        'type'  => 'browse',

                    ]
                ],
                'fake' => true,
                'store_in' => 'docs',
                'tab' => trans('admin.documents'),
            ]
        ]);

        $this->addSeoFields();
    }

    protected function setupReorderOperation()
    {
        parent::setupReorderOperation();
        CRUD::set('reorder.max_level', 0);
    }

}
