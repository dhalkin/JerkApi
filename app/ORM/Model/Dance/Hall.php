<?php

namespace App\ORM\Model\Dance;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    public $timestamps = false;
    protected $table = 'dance_halls';
    
    protected $hidden = ['id', 'unique_id', 'company_id', 'created_at', 'updated_at'];
    
    public static function boot()
    {
        parent::boot();
        
        self::creating(function ($model) {
            $model->unique_id = md5(microtime());
        });
    }
    
    public function preSave()
    {
        return true;
    }
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
