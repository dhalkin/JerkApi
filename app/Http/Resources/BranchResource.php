<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            //'id' => $this->id,
            'name' => $this->name,
            'uid' => $this->uid,
            'address'=> $this->address,
            'active'=> (bool) $this->active,
            'about' => $this->about,
            'halls' => HallResource::collection($this->whenLoaded('halls'))
        ];
    }
}
