<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CityRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\City;

class CityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public function setup()
    {
        CRUD::setModel(City::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/city');
        CRUD::setEntityNameStrings(trans_choice('admin.cities', 1), trans_choice('admin.cities', 2));
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
                'name' => 'address',
                'label' => trans('admin.address'),
            ],
            [
                'name' => 'phones',
                'label' => trans('admin.phone'),
                'type' => 'table',
                'columns' => [
                    'phone' => '',
                ],
            ],
            [
                'name' => 'support',
                'label' => trans('admin.support'),
                'type' => 'table',
                'columns' => [
                    'label' => ''
                ],
            ],
            [
                'name' => 'faxes',
                'label' => trans('admin.fax'),
                'type' => 'table',
                'columns' => [
                    'fax' => ''
                ],
            ],
            [
                'name' => 'emails',
                'label' => trans('admin.email'),
                'type' => 'table',
                'columns' => [
                    'email' => ''
                ],
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
            ],
            [
                'name' => 'coords',
                'label' => trans('admin.coordinates'),
                'type' => 'table',
                'columns' => [
                    'lat' => trans('admin.lat'),
                    'long' => trans('admin.long'),
                ],
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
        CRUD::setValidation(CityRequest::class);

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
                'options' => City::getStatusOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-6',
                ],
            ],
            [
                'name' => 'coords',
                'label' => trans('admin.coordinates'),
                'type' => 'repeatable',
                'init_rows' => 0,
                'fields' => [
                    [
                        'name' => 'lat',
                        'label' => trans('admin.lat'),
                        'attributes' => [
                            'required' => true,
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-sm-6 required'
                        ],
                    ],
                    [
                        'name' => 'long',
                        'label' => trans('admin.long'),
                        'attributes' => [
                            'required' => true,
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-sm-6 required'
                        ],
                    ],
                ],
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'address',
                'label' => trans('admin.address'),
                'type' => 'textarea',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
                'type' => 'textarea',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'phones',
                'label' => trans('admin.phones'),
                'type' => 'repeatable',
                'init_rows' => 0,
                'fields' => [
                    [
                        'name' => 'phone',
                        'label' => trans('admin.phone'),
                        'attributes' => [
                            'required' => true,
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-sm-12 required'
                        ]
                    ],
                ],
                'tab' => trans('templates.contacts'),
            ],
            [
                'name' => 'emails',
                'label' => trans('admin.email'),
                'type' => 'repeatable',
                'init_rows' => 0,
                'fields' => [
                    [
                        'name' => 'email',
                        'label' => trans('admin.email'),
                        'attributes' => [
                            'required' => true,
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-sm-12 required'
                        ]
                    ],
                ],
                'tab' => trans('templates.contacts'),
            ],
            [
                'name' => 'faxes',
                'label' => trans('admin.fax'),
                'type' => 'repeatable',
                'init_rows' => 0,
                'fields' => [
                    [
                        'name' => 'fax',
                        'label' => trans('admin.fax'),
                        'attributes' => [
                            'required' => true,
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-sm-12 required'
                        ]
                    ],
                ],
                'tab' => trans('templates.contacts'),
            ],
            [
                'name' => 'support',
                'label' => trans('admin.support'),
                'type' => 'repeatable',
                'init_rows' => 0,
                'fields' => [
                    [
                        'name' => 'label',
                        'label' => trans('admin.text'),
                        'attributes' => [
                            'required' => true,
                        ],
                        'wrapperAttributes' => [
                            'class' => 'form-group col-sm-12 required'
                        ]
                    ],
                ],
                'tab' => trans('templates.contacts'),
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
