<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Partnership;

class PartnershipCrudController extends CallbackCrudController
{

    public function setup()
    {
        CRUD::setModel(Partnership::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/partnership');
        CRUD::setEntityNameStrings(trans_choice('admin.partnership', 1), trans_choice('admin.partnership', 2));

        CRUD::addClause('latest');
        CRUD::denyAccess(['create', 'update']);

        CRUD::addClause('where', 'is_partnership', 1);
    }

}
