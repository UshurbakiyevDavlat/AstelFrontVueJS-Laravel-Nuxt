<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;
use App\Services\Page\Contracts\HasInnerPage;

use App\Repositories\ServiceRepository;

class Services extends Template implements HasInnerPage
{

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'content' => $page->getData('content'),
            'services' => $this->serviceRepository->main(),
        ]);
    }

    public function prepareRelated(Page $page, $slug) : array
    {
        $data = $this->serviceRepository->process($slug);
        $service = $data['service'];
        $data['service'] = $this->serviceRepository->toResource($service);

        return array_merge(
            parent::prepareRelated($page, $slug),
            $data,
            $data['service']->getSeoTags(),
        );
    }

    public function getColumns() : array
    {
        return array_merge(parent::getColumns(), [
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'markdown',
            ],
        ]);
    }

    public function getFields() : array
    {
        return array_merge(parent::getFields(), [
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans('admin.content'),
            ],
        ]);
    }



}
