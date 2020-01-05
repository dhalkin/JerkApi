<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\ORM\Model\Color;
use App\ORM\Model\EventCompanyUser;

class EventResource extends JsonResource
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
            'title' => $this->title(), //sprintf("<strong>%s</strong>", $this->group->name),
            'start'=> $this->start,
            'end'=> $this->finish,
            'backgroundColor' => Color::find($this->group->color_id)->rgba,
            'trainer' => 'Coach',
            'hall' => $this->hall->name,
            'hallAddress' => $this->hall->address,
            'peopleStats' => $this->group->max_person - $this->getAttended(),
            'personalStatus' => $this->getPersonalStatus()
        ];
    }
    
    private function title()
    {
        return $this->group->name;
        
    }
    
    private function getAttended()
    {
        return 6;
    }
}
