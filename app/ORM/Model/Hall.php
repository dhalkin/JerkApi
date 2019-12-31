<?php

namespace App\ORM\Model;

use Illuminate\Database\Eloquent\Model;

/*
* @property int id
* @property string $uniqueId
* @property int $companyId
* @property string $name
* @property string $address
* @property bool $active
* @property Carbon $createdAt
* @property Carbon $updatedAt
*
* @method int getId()
* @method string getUniqueId()
* @method string getName()
* @method Carbon getUpdatedAt()
* @method Carbon getCreatedAt()
 *
 */

class Hall extends Model
{
    protected $table = 'halls';
    
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
