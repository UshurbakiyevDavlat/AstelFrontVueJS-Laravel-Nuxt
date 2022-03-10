<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'address' => $this->address,
            'description' => $this->description,
            'coords' => $this->coords,
            'support' => $this->support,
            'phones' => $this->phones,
            'faxes' => $this->faxes,
            'emails' => $this->emails,
        ];
    }
}
