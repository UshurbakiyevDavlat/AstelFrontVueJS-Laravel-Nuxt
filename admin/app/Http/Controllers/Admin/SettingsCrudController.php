<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettingsRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Services\Settings\Models\Settings;

class SettingsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Settings::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/settings');
        CRUD::setEntityNameStrings(trans_choice('admin.settings', 1), trans_choice('admin.settings', 2));

        CRUD::denyAccess([
            'create', 'delete'
        ]);
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
                'type' => 'check'
            ],
            [
                'name' => 'value',
                'label' => trans('admin.value'),
                'type' => 'text'
            ],
            [
                'name' => 'key',
                'label' => trans('admin.key'),
                'type' => 'text'
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SettingsRequest::class);

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
                'attributes' => [
                    'required' => true
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12 required'
                ],
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select2_from_array',
                'options' => Settings::getStatusOptions(),
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
                'type' => 'textarea',
                'tab' => trans('admin.main'),
            ],
        ]);
    }

    protected function setupShowOperation()
    {
        parent::setupShowOperation();

        CRUD::addColumn([
            'name' => 'description',
            'label' => trans('admin.description'),
            'type' => 'markdown',
        ])->afterColumn('name');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        $entry = CRUD::getCurrentEntry();
        $field = $entry->field;
        CRUD::addField(
            array_merge(
                $field,
                [
                    'tab' => trans('admin.main')
                ]
            )
        )->beforeField('description');
    }
}
