<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\JobApplicationRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\JobApplication;

class JobApplicationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(JobApplication::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/jobapplication');
        CRUD::setEntityNameStrings(trans_choice('admin.job_applications', 1), trans_choice('admin.job_applications', 2));

        CRUD::denyAccess(['create', 'update']);
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
                'name' => 'vacancy',
                'label' => trans('admin.vacancy'),
                'type' => 'relationship',
                'attribute' => 'name',
            ],
            [
                'name' => 'full_name',
                'label' => trans('admin.full_name'),
            ],
            [
                'name' => 'phone',
                'label' => trans('admin.phone'),
                'type' => 'phone'
            ],
            [
                'name' => 'email',
                'label' => trans('admin.email'),
                'type' => 'email',
            ],
            [
                'name' => 'cv',
                'label' => trans('admin.cv'),
                'type' => 'upload',
                'disk' => 'elfinder',
            ],
            [
                'name' => 'message',
                'label' => trans('admin.cv_message'),
                'limit' => 500
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(JobApplicationRequest::class);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
