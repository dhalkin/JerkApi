<?php

namespace App\ORM\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    public $timestamps = false;
    protected $hidden = ['id', 'company_id', 'group_id', 'hall_id'];
    protected $table = 'events';
    
    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }
    
    public function hall()
    {
        return $this->hasOne(Hall::class, 'id', 'hall_id');
    }
}
