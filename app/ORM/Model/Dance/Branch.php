<?php

namespace App\ORM\Model\Dance;


class Branch extends BaseUIDModel
{
    protected $table = 'dance_branches';
    protected $hidden = ['company_id'];
    public $timestamps = false;
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'id', 'company_id');
    }
    
    public function halls()
    {
        return $this->hasMany(Hall::class, 'branch_id', 'id');
    }
    
    public function getUid()
    {
        return $this->uid;
    }
    public function getId()
    {
        return $this->id;
    }
}
