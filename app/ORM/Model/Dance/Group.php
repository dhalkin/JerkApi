<?php

namespace App\ORM\Model\Dance;

use Illuminate\Database\Eloquent\Model;
use App\ORM\Model\Color;

class Group extends BaseUIDModel
{
    protected $table = 'dance_groups';
    protected $hidden = ['id', 'company_id'];
    public $timestamps = false;
    
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
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function direction()
    {
        return $this->hasOne(Direction::class, 'id', 'direction_id');
    }
    
}
