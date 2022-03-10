<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;

use App\Models\City;
use App\Http\Resources\CityResource;

class Contacts extends Template
{
    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'departments' => $page->getData('departments'),
            'cities' => City::active()->orderBy('lft')->get()->map(function($city) {
                return new CityResource($city);
            })
        ]);
    }

    public function getFields() : array
    {
        return [
            [
                'name' => 'departments',
                'label' => trans('admin.departments'),
                'type' => 'repeatable',
                'init_rows' => 0,
                'fields' => [
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
                        'name' => 'phone',
                        'label' => trans('admin.phone'),
                        'wrapperAttributes' => [
                            'class' => 'form-group col-sm-6'
                        ],
                    ],
                    [
                        'name' => 'email',
                        'label' => trans('admin.email'),
                        'wrapperAttributes' => [
                            'class' => 'form-group col-sm-6'
                        ],
                    ],
                ],
                'tab' => trans('admin.main'),
            ],
        ];
    }

}
