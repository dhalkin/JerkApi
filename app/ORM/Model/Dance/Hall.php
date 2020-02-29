<?php

namespace App\ORM\Model\Dance;


class Hall extends BaseUIDModel
{
    public $timestamps = false;
    protected $table = 'dance_halls';
    
    protected $hidden = ['id'];
    
    
    public function preSave()
    {
        return true;
    }
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
    
    public function getUid()
    {
        return $this->uid;
    }
}
