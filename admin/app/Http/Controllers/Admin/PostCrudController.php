<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Post;

class PostCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Post::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post');
        CRUD::setEntityNameStrings(trans_choice('admin.posts', 1), trans_choice('admin.posts', 2));

        CRUD::addClause('orderBy', 'id', 'DESC');
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
                'height' => 'auto'
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
                'type' => 'text',
            ],
            [
                'name' => 'published_at',
                'label' => trans('admin.published_at'),
                'type' => 'date'
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
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'markdown',
            ],
        ]);

        $this->addSeoColumns();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(PostRequest::class);

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
                'options' => Post::getStatusOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-6'
                ],
            ],
            [
                'name' => 'published_at',
                'label' => trans('admin.published_at'),
                'type' => 'date',
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
                'type' => 'textarea',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans('admin.content')
            ],
        ]);

        $this->addSeoFields();
    }

}
