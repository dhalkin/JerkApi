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
            'color_id' => $this->color_id,
            'default_trainer_id' => $this->default_trainer_id,
            'uid' => $this->uid,
            'max_person'=> $this->max_person,
            'duration_min' => $this->duration_min,
            'about' => $this->about,
            '_cellVariants'=> ['name'=>strtolower($this->color->name)]
        ];
    }
}
