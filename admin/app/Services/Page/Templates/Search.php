<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;
use App\Services\Page\Contracts\HasInnerPage;

class Search extends Template implements HasInnerPage
{

    public function menu() : bool
    {
        return false;
    }

    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'results' => [],
        ]);
    }

    public function prepareRelated(Page $page, $slug) : array
    {
        return array_merge(
            parent::prepareRelated($page, $slug),
            [
                'component' => 'search',
                'results' => \Elasticsearch::search($slug, 20, request()->input('page', 1)),
            ],
        );
    }

}
