<?php

namespace App\ORM\Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $hidden = ['id', 'company_id', 'direction_id'];
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
