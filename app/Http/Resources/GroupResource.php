<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'color'=> $this->color->hex,
            'max_person'=> $this->max_person,
            'duration' => $this->duration_min,
            'about' => $this->about
        ];
    }
}
