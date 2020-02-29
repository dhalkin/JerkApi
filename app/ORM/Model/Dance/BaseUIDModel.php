<?php

namespace App\ORM\Model\Dance;

use Illuminate\Database\Eloquent\Model;

class BaseUIDModel extends Model
{
    public static function boot()
    {
        parent::boot();
        
        self::creating(function ($model) {
            $model->uid = md5(microtime());
        });
    }
}
