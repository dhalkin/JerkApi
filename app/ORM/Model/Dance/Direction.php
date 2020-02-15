<?php

namespace App\ORM\Model\Dance;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $table = 'dance_directions';
    protected $hidden = ['id', 'company_id'];
    
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
