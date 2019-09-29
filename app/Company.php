<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    
    protected $hidden = ['id', 'user_id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    public function branches()
    {
        return $this->hasMany('App\Branch', 'company_id', 'id');
    }
    
    public function halls()
    {
        return $this->hasMany('App\Hall', 'company_id', 'id');
    }
}
