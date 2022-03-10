<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;

use App\Repositories\ServiceRepository;
use App\Repositories\PostRepository;

use App\Models\Partner;
use App\Http\Resources\PartnerResource;

use App\Models\City;
use App\Http\Resources\CityResource;

class Home extends Template
{

    public function __construct(ServiceRepository $serviceRepository, PostRepository $postRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->postRepository = $postRepository;
    }

    public function menu() : bool
    {
        return false;
    }

    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'services' => $this->serviceRepository->main(),
            'posts' => $this->postRepository->latest(),
            'partners' => Partner::active()->orderBy('lft')->get()->map(function($partner) {
                return new PartnerResource($partner);
            }),
            'cities' => City::active()->orderBy('lft')->get()->map(function($city) {
                return new CityResource($city);
            }),

//            'title' => $page->getData('title'),
//            'subtitle' => $page->getData('subtitle'),
//            'description' => $page->getData('description'),
//            'videos' => elfinder($page->getData('videos')),
//            'link' => $page->getData('link'),

            'title1' => $page->getData('title1'),
            'subtitle1' => $page->getData('subtitle1'),
            'description1' => $page->getData('description1'),

            'title2' => $page->getData('title2'),
            'subtitle2' => $page->getData('subtitle2'),
            'description2' => $page->getData('description2'),

            'title3' => $page->getData('title3'),
            'subtitle3' => $page->getData('subtitle3'),
            'description3' => $page->getData('description3'),

            'title4' => $page->getData('title4'),
            'subtitle4' => $page->getData('subtitle4'),
            'description4' => $page->getData('description4'),

            'title5' => $page->getData('title5'),
            'subtitle5' => $page->getData('subtitle5'),
            'description5' => $page->getData('description5'),

            'titleMobile1' => $page->getData('titleMobile1'),
            'subtitleMobile1' => $page->getData('subtitleMobile1'),
            'descriptionMobile1' => $page->getData('descriptionMobile1'),

            'titleMobile2' => $page->getData('titleMobile2'),
            'subtitleMobile2' => $page->getData('subtitleMobile2'),
            'descriptionMobile2' => $page->getData('descriptionMobile2'),

            'titleMobile3' => $page->getData('titleMobile3'),
            'subtitleMobile3' => $page->getData('subtitleMobile3'),
            'descriptionMobile3' => $page->getData('descriptionMobile3'),

            'titleMobile4' => $page->getData('titleMobile4'),
            'subtitleMobile4' => $page->getData('subtitleMobile4'),
            'descriptionMobile4' => $page->getData('descriptionMobile4'),

            'titleMobile5' => $page->getData('titleMobile5'),
            'subtitleMobile5' => $page->getData('subtitleMobile5'),
            'descriptionMobile5' => $page->getData('descriptionMobile5'),

            'image1' => elfinder($page->getData('image1')),
            'image2' => elfinder($page->getData('image2')),
            'image3' => elfinder($page->getData('image3')),
            'image4' => elfinder($page->getData('image4')),
            'image5' => elfinder($page->getData('image5')),

            'imageMobile1' => elfinder($page->getData('imageMobile1')),
            'imageMobile2' => elfinder($page->getData('imageMobile2')),
            'imageMobile3' => elfinder($page->getData('imageMobile3')),
            'imageMobile4' => elfinder($page->getData('imageMobile4')),
            'imageMobile5' => elfinder($page->getData('imageMobile5')),

            'link1' => $page->getData('link1'),
            'link2' => $page->getData('link2'),
            'link3' => $page->getData('link3'),
            'link4' => $page->getData('link4'),
            'link5' => $page->getData('link5'),

            'linkMobile1' => $page->getData('linkMobile1'),
            'linkMobile2' => $page->getData('linkMobile2'),
            'linkMobile3' => $page->getData('linkMobile3'),
            'linkMobile4' => $page->getData('linkMobile4'),
            'linkMobile5' => $page->getData('linkMobile5'),

            'services_title' => $page->getData('services_title'),
            'services_content' => $page->getData('services_content'),
            'partners_title' => $page->getData('partners_title'),
            'partners_content' => $page->getData('partners_content'),
            'contacts_title' => $page->getData('contacts_title'),
            'contacts_image' => elfinder($page->getData('contacts_image')),
        ]);
    }

    public function getFields() : array
    {
        return [
            [
                'name' => 'image1',
                'label' => trans('admin.image'),
                'type' => 'image',
                'multiple' => true,
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'imageMobile1',
                'label' => trans('admin.imageMobile'),
                'type' => 'image',
                'multiple' => true,
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'link1',
                'label' => trans('admin.link'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'title1',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'subtitle1',
                'label' => trans('admin.subtitle'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'description1',
                'label' => trans('admin.description'),
                'type' => 'textarea',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'image2',
                'label' => trans('admin.image'),
                'type' => 'image',
                'multiple' => true,
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'imageMobile2',
                'label' => trans('admin.imageMobile'),
                'type' => 'image',
                'multiple' => true,
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'link2',
                'label' => trans('admin.link'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'title2',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'subtitle2',
                'label' => trans('admin.subtitle'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'description2',
                'label' => trans('admin.description'),
                'type' => 'textarea',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'image3',
                'label' => trans('admin.image'),
                'type' => 'image',
                'multiple' => true,
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'imageMobile3',
                'label' => trans('admin.imageMobile'),
                'type' => 'image',
                'multiple' => true,
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'link3',
                'label' => trans('admin.link'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'title3',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'subtitle3',
                'label' => trans('admin.subtitle'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'description3',
                'label' => trans('admin.description'),
                'type' => 'textarea',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'image4',
                'label' => trans('admin.image'),
                'type' => 'image',
                'multiple' => true,
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'imageMobile4',
                'label' => trans('admin.imageMobile'),
                'type' => 'image',
                'multiple' => true,
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'link4',
                'label' => trans('admin.link'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'title4',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'subtitle4',
                'label' => trans('admin.subtitle'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'description4',
                'label' => trans('admin.description'),
                'type' => 'textarea',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'image5',
                'label' => trans('admin.image'),
                'type' => 'image',
                'multiple' => true,
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'imageMobile5',
                'label' => trans('admin.imageMobile'),
                'type' => 'image',
                'multiple' => true,
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'link5',
                'label' => trans('admin.link'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'title5',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'subtitle5',
                'label' => trans('admin.subtitle'),
                'type' => 'text',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'description5',
                'label' => trans('admin.description'),
                'type' => 'textarea',
                'tab' => trans('admin.main'),
            ],
            [
                'name' => 'services_title',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans_choice('admin.services', 2),
            ],
            [
                'name' => 'services_content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans_choice('admin.services', 2)
            ],
            [
                'name' => 'partners_title',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans_choice('admin.partners', 2),
            ],
            [
                'name' => 'partners_content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
                'tab' => trans_choice('admin.partners', 2)
            ],
            [
                'name' => 'contacts_title',
                'label' => trans('admin.title'),
                'type' => 'text',
                'tab' => trans('templates.contacts'),
            ],
            [
                'name' => 'contacts_image',
                'label' => trans('admin.image'),
                'type' => 'image',
                'tab' => trans('templates.contacts')
            ],
        ];
    }

}
