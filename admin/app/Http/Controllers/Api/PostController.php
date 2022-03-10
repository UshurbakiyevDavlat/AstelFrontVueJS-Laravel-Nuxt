<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PostRepository;

class PostController extends Controller
{

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function paginate()
    {
        return $this->postRepository->paginate();
    }

}
