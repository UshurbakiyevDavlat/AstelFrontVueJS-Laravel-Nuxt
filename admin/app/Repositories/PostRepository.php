<?php

namespace App\Repositories;

use App\Models\Post;

use App\Http\Resources\PostResource;

class PostRepository extends Repository
{

    public function paginate($per_page = 6)
    {
        $data = Post::published()->paginate($per_page)->withPath(route('posts'));

        return $data->setCollection($data->getCollection()->transform(function($post) {
            return $post->simple();
        }));
    }

    public function latest()
    {
        return Post::published()->take(4)->get()->map(function($post) {
            return $post->simple();
        });
    }

    public function show(string $slug) : Post
    {
        return Post::published()->findBySlugOrFail($slug);
    }

    public function toResource(Post $post) : PostResource
    {
        return new PostResource($post);
    }

}
