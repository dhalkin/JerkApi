<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyUserResource extends JsonResource
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
            'name' => ['first_name'=>$this->first_name, 'second_name'=>$this->second_name],
            'phone' => $this->phone,
            'role_id' => $this->role_id,
            'email' => $this->email,
            'active'=> (boolean) $this->active,
            'about' => $this->about
        ];
    }
}
