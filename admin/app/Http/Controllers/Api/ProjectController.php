<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\ProjectRepository;

class ProjectController extends Controller
{

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function paginate()
    {
        return $this->projectRepository->paginate();
    }

}
