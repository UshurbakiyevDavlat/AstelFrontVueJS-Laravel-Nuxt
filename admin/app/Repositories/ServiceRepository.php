<?php

namespace App\Repositories;

use App\Models\Service;
use App\Http\Resources\ServiceResource;

class ServiceRepository extends Repository
{

    public function main()
    {
        return Service::main()->get()->map(function($service) {
            return $service->simple();
        });
    }

    public function process(string $slug)
    {
        $items = array_filter(explode('/', $slug));

        $query = Service::main();
        $prev = null;

        foreach($items as $index => $slug) {
            $prev2 = $prev;
            $prev = clone $query;
            $service = $query->findBySlugOrFail($slug);
            $query = $service->childServices()->active()->orderBy('lft');
        }

        $sbs_count = $query->count();
        if ($sbs_count == 0 && $prev2) {
            $categories = $prev2->get();
            $label = $categories->first()->parentService->name ?? null;
            $subcategories = collect([]);
            $aside_subcategories = $prev->get();
        } else {
            $categories = $prev->get();
            $label = $categories->first()->parentService->name ?? null;
            $subcategories = $query->get();
            $aside_subcategories = collect([]);
        }

        return [
            'label' => $label,
            'service' => $service,
            'categories' => $categories->map(function($service) {
                return $service->simple();
            }),
            'subcategories' => $subcategories->map(function($service) {
                return $service->simple();
            }),
            'aside_subcategories' => $aside_subcategories->map(function($service) {
                return $service->simple();
            }),
        ];

        return $data;
    }

    public function toResource(Service $service) : ServiceResource
    {
        return new ServiceResource($service);
    }

}
