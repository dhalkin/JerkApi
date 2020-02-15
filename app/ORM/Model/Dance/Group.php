<?php

namespace App\ORM\Model\Dance;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'dance_groups';
    protected $hidden = ['id', 'company_id', 'direction_id'];
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function color()
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }
}
