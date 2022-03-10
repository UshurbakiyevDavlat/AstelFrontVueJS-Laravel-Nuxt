<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CallbackRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Callback;

class CallbackCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Callback::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/callback');
        CRUD::setEntityNameStrings(trans_choice('admin.callbacks', 1), trans_choice('admin.callbacks', 2));

        CRUD::addClause('latest');
        CRUD::denyAccess(['create', 'update']);

        CRUD::addClause('where', 'is_partnership', 0);
        CRUD::addClause('notServicecallback');
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

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CallbackRequest::class);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
