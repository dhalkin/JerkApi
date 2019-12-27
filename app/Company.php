<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $hidden = ['id', 'user_id', 'created_at', 'updated_at'];

    protected $fillable = ['user_id', 'name'];

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

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function halls()
    {
        return $this->hasMany('App\Hall', 'company_id', 'id');
    }
}
