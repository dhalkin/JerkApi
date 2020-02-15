<?php

namespace App\ORM\Model\Dance;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'dance_companies';

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
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function halls()
    {
        return $this->hasMany(Hall::class, 'company_id', 'id');
    }
}
