<?php

namespace App\Services\Elasticsearch\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'template' => $this->getElasticTemplate(),
            'slug' => $this->getElasticSlug(),
            'title' => $this->getElasticTitle(),
            'description' => $this->getElasticDescription(),
        ];
    }
}
