<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => elfinder($this->image),
            'images' => elfinder($this->images),
            'published_at' => $this->published_at,
            'labels' => json_decode_recursive($this->labels),
            'consultation' => $this->consultation,
            'content' => $this->content,
        ];
    }
}
