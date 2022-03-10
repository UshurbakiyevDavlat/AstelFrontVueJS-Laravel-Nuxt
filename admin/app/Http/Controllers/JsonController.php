<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;


class JsonController extends BaseController
{

    public function json()
    {

        return DB::select('select * from posts order by created_at ASC limit 96');

    }

}
