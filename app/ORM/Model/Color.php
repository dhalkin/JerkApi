<?php

namespace App\ORM\Model;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';
    protected $hidden = ['id'];
    
    public function group()
    {
        return $this->belongsTo('Group');
    }
    
    
    
}
