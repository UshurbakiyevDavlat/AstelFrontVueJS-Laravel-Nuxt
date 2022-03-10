<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'slug' => $this->getFullSlug(),
            'content' => $this->content,
            'advantages_title' => $this->getData('advantages_title'),
            'advantages' => array_map(function($item) {
                return [
                    'name' => $item->name,
                    'image' => elfinder($item->image),
                ];
            }, array_filter((array)$this->getData('advantages'), function($item) {
                return $item->name && $item->image;
            })),
            'documents' => array_map(function($item) {
                return [
                    'name' => $item->name,
                    'file' => elfinder($item->path),
                ];
            }, array_filter((array)$this->getDocs('documents'), function($item) {
                return $item->name && $item->path;
            })),
            'connection_title' => $this->getData('connection_title'),
            'connection_content' => $this->getData('connection_content'),
            'connection_items' => $this->getData('connection_items'),
            'breadcrumbs' => $this->breadcrumbs(),
        ];
    }
}
