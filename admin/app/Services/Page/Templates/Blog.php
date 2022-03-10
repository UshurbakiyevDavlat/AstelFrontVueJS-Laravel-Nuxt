<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;
use App\Services\Page\Contracts\HasInnerPage;

use App\Repositories\PostRepository;

class Blog extends Template implements HasInnerPage
{

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'posts' => $this->postRepository->paginate(),
            'pagination' => 'posts'
        ]);
    }

    public function prepareRelated(Page $page, $slug) : array
    {
        $post = $this->postRepository->show($slug);
        return array_merge(parent::prepareRelated($page, $slug), [
            'post' => $this->postRepository->toResource($post)
        ], $post->getSeoTags());
    }

}
