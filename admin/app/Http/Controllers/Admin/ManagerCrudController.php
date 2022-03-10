<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ManagerRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Manager;

class ManagerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public function setup()
    {
        CRUD::setModel(Manager::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/manager');
        CRUD::setEntityNameStrings(trans_choice('admin.managers', 1), trans_choice('admin.managers', 2));

        CRUD::addClause('orderBy', 'lft');
    }

    protected function setupListOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'image',
                'label' => trans('admin.image'),
                'type' => 'image',
                'disk' => 'elfinder',
                'width' => '80px',
                'height' => 'auto',
            ],
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
                'name' => 'description',
                'label' => trans('admin.description'),
                'type' => 'markdown',
            ],
            [
                'name' => 'link',
                'label' => trans('admin.link'),
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
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ManagerRequest::class);

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => trans('admin.full_name'),
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
                'options' => Manager::getStatusOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-6'
                ],
            ],
            [
                'name' => 'image',
                'label' => trans('admin.image'),
                'type' => 'image',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
                'type' => 'ckeditor',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'link',
                'label' => trans('admin.link'),
                'type' => 'url',
                'tab' => trans('admin.main'),
            ],
        ]);
    }
}
