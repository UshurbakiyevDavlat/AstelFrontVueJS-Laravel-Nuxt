<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;

class Signin extends Template
{

    public function menu() : bool
    {
        return false;
    }

    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            //
        ]);
    }

}
