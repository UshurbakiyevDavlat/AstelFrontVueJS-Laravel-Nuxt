<?php

namespace App\Repositories;

use App\Models\Project;

use App\Http\Resources\ProjectResource;

class ProjectRepository extends Repository
{

    public function paginate($per_page = 6)
    {
        $data = Project::published()->paginate($per_page)->withPath(route('projects'));

        return $data->setCollection($data->getCollection()->transform(function($project) {
            return $project->simple();
        }));
    }

    public function show(string $slug) : Project
    {
        return Project::published()->findBySlugOrFail($slug);
    }

    public function toResource(Project $project) : ProjectResource
    {
        return new ProjectResource($project);
    }

}
