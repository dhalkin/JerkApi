<?php

namespace App\ORM\Model;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $table = 'directions';
    protected $hidden = ['id', 'company_id'];
    
    public function group()
    {
        return $this->belongsTo('Group');
    }
}
