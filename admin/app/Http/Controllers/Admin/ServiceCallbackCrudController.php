<?php

namespace App\Http\Controllers\Admin;

use App\Models\Callback;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ServiceCallbackCrudController extends CallbackCrudController
{

    public function setup()
    {
        CRUD::setModel(Callback::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/service-callback');
        CRUD::setEntityNameStrings(trans_choice('admin.service_callbacks', 1), trans_choice('admin.service_callbacks', 2));

        CRUD::addClause('latest');
        CRUD::denyAccess(['create', 'update']);

        CRUD::addClause('where', 'is_partnership', 0);
        CRUD::addClause('servicecallback');
    }

    protected function setupListOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'row_number',
                'label' => '#',
                'type' => 'row_number',
            ],
            [
                'name' => 'service_id',
                'label' => trans('admin.service'),
                'type' => 'relationship',
                'attribute' => 'name',
            ],
            [
                'name' => 'name',
                'label' => trans('admin.first_name'),
            ],
            [
                'name' => 'phone',
                'label' => trans('admin.phone'),
                'type' => 'phone',
            ],
            [
                'name' => 'email',
                'label' => trans('admin.email'),
                'type' => 'email',
            ],
            [
                'name' => 'city',
                'label' => trans('admin.city'),
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
                'name' => 'message',
                'label' => trans('admin.message'),
                'limit' => 500,
            ],
        ]);
    }

}
