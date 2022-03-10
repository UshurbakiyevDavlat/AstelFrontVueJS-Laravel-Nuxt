<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LicenseRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\License;

class LicenseCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public function setup()
    {
        CRUD::setModel(License::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/license');
        CRUD::setEntityNameStrings(trans_choice('admin.licenses', 1), trans_choice('admin.licenses', 2));

        CRUD::addClause('orderBy', 'lft');
    }

    protected function setupListOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'file',
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
        CRUD::setValidation(LicenseRequest::class);

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
                'type' => 'text',
                'attributes' => [
                    // 'requiired' => true
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12 required'
                ]
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select2_from_array',
                'options' => License::getStatusOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-6'
                ],
            ],
            [
                'name' => 'file',
                'label' => trans('admin.image'),
                'type' => 'image',
                'tab' => trans('admin.main'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12 required'
                ]
            ],
        ]);
    }
}
