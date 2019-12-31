<?php


namespace App\Transformers;

use App\Event;

class CalendarTransformer
{
    public function transform(Event $event) {
        
        return [
            'title' => $event->group()->name,
            'start'=> $event->start,
            'end'=> $event->finish,
        ];
    }


}
