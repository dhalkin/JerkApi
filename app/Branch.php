<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';
    
    protected $hidden = ['id', 'company_id', 'created_at', 'updated_at'];
    
    public static function boot()
    {
        parent::boot();
    
        self::creating(function ($model) {
            sleep(1);
        });
    
        self::created(function ($model) {
            sleep(1);
        });
    
    }
    
    public function preSave()
    {
        return true;
    }
  
}