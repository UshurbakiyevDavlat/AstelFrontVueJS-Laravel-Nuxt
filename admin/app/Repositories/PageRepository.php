<?php

namespace App\Repositories;

use App\Models\Service;
use App\Services\Page\Models\Page;

class PageRepository extends Repository
{

    public function getMap() : array
    {
        return Page::active()
            ->get()
            ->map(function($page) {
                return $page->simple();
            })
            ->keyBy('template')
            ->toArray();
    }

    public function getMenu() : array
    {
        return Page::where('parent_id', null)
                    ->simple()
                    ->menu()
                    ->orderBy('lft')
                    ->with([
                        'childPages' => function($query) {
                            $query->active()
                                  ->simple()
                                  ->menu()
                                  ->orderBy('lft');
                        }
                    ])
                    ->get()
                    ->map(
                        function($page) {
                            return array_merge(
                                $page->simple(),
                                [
                                    'childPages' => $page->childPages->map(function($page) {
                                        return $page->simple();
                                    }),
                                ]
                            );
                        }
                    )->toArray();
    }


//    }

    public function getMenuServices() : array
    {
        return Service::where('parent_id', null)
            ->orderBy('lft')
            ->with([
                'childServices' => function($query) {
                    $query
                        ->active()
                        ->orderBy('lft');
                }
            ])
            ->get()
            ->map(
                function($page) {
                    return array_merge(
                        $page->simple(),
                        [
                            'grandChildService' =>$this->grandchildServices(),
                            'childServices' => $page->childServices->map(function($page) {
                                return $page->simple();
                            }),
                        ]
                    );
                }
            )
            ->toArray();
    }

    public function grandchildServices()
    {
        $ids = [2, 16, 20, 27, 32, 31, 35];
        return Service::query()
            ->select('id','name','image','slug','parent_id')
            ->whereIn('parent_id',$ids)
            ->orderBy('lft')
            ->active()
            ->get();
    }



}
