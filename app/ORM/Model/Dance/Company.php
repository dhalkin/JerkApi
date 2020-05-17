<?php

namespace App\ORM\Model\Dance;

use App\ORM\Model\User;

class Company extends BaseUIDModel
{
    protected $table = 'dance_companies';

    protected $hidden = ['id', 'user_id', 'created_at', 'updated_at'];

    protected $fillable = ['user_id', 'name'];

    public function preSave()
    {
        return true;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    
    public function branches()
    {
        return $this->hasMany(Branch::class, 'company_id', 'id');
    }
    
    public function getId()
    {
        return $this->id;
    }
}
