<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VacancyRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


use App\Models\Vacancy;

class VacancyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public function setup()
    {
        CRUD::setModel(Vacancy::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vacancy');
        CRUD::setEntityNameStrings(trans_choice('admin.vacancies', 1), trans_choice('admin.vacancies', 2));
    }

    protected function setupListOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'row_number',
                'label' => '#',
                'type' => 'row_number'
            ],
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'check'
            ],
            [
                'name' => 'salary',
                'label' => trans('admin.salary'),
            ],
            [
                'name' => 'updated_at',
                'label' => trans('admin.updated_at'),
                'type' => 'datetime'
            ],
            [
                'name' => 'created_at',
                'type' => trans('admin.created_at'),
                'type' => 'datetime',
            ],
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'markdown',
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(VacancyRequest::class);

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
                'options' => Vacancy::getStatusOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-6'
                ],
            ],
            [
                'name' => 'salary',
                'label' => trans('admin.salary'),
                'type' => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-6'
                ],
            ],
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans('admin.main')
            ],
        ]);
    }
}
