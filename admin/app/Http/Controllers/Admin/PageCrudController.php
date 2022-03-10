<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PageRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Services\Page\Models\Page;

class PageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;


    public function setup()
    {
        CRUD::setModel(Page::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/page');
        CRUD::setEntityNameStrings(trans_choice('admin.pages', 1), trans_choice('admin.pages', 2));
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
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select_from_array',
                'options' => Page::getStatusOptions(),
            ],
            [
                'name' => 'slug',
                'label' => trans('admin.slug'),
            ],
            [
                'name' => 'template',
                'label' => trans('admin.template'),
                'type' => 'select_from_array',
                'options' => Page::getTemplateOptions()
            ],
            [
                'name' => 'updated_at',
                'label' => trans('admin.updated_at'),
                'type' => 'datetime',
            ],
            [
                'name' => 'created_at',
                'label' => trans('admin.created_at'),
                'type' => 'datetime'
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(PageRequest::class);

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
                'options' => Page::getStatusOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-6'
                ],
            ],
            [
                'name' => 'template',
                'label' => trans('admin.template'),
                'type' => 'select2_from_array',
                'options' => Page::getTemplateOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-6 required'
                ],
            ],

        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        CRUD::removeField('template');

        $entry = CRUD::getCurrentEntry();
        $template = $entry->getTemplate();
        CRUD::addFields($template->getAllFields());
        CRUD::addField([
            'name' => 'slug',
            'label' => trans('admin.slug'),
            'hint' => trans('admin.slug_hint'),
            'tab' => trans('admin.seo'),
        ])->beforeField('seo_title');
    }

    protected function setupShowOperation()
    {
        parent::setupShowOperation();

        $entry = CRUD::getCurrentEntry();
        $template = $entry->getTemplate();
        CRUD::addColumns($template->getAllColumns());
    }

    protected function setupReorderOperation()
    {
        parent::setupReorderOperation();

        CRUD::addClause('menu');
    }
}
