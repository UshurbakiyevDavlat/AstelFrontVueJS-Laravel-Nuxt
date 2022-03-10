<?php

namespace App\Services\Page\Templates;

use App\Services\Page\Template;
use App\Services\Page\Models\Page;
use App\Services\Page\Contracts\HasInnerPage;

use App\Repositories\ProjectRepository;

class Projects extends Template implements HasInnerPage
{

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function prepare(Page $page) : array
    {
        return array_merge(parent::prepare($page), [
            'projects' => $this->projectRepository->paginate(),
            'pagination' => 'projects'
        ]);
    }

    public function prepareRelated(Page $page, $slug) : array
    {
        $project = $this->projectRepository->show($slug);
        return array_merge(parent::prepareRelated($page, $slug), [
            'project' => $this->projectRepository->toResource($project)
        ], $project->getSeoTags());
    }

}
