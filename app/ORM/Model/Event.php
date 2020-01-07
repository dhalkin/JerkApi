<?php

namespace App\ORM\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    public $timestamps = false;
    public $personalStatus = false;
    protected $hidden = ['id', 'company_id', 'group_id', 'hall_id'];
    protected $table = 'events';
    
    
    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }
    
    public function hall()
    {
        return $this->hasOne(Hall::class, 'id', 'hall_id');
    }
    
    public function trainer()
    {
        return $this->hasOne(CompanyUser::class, 'id', 'trainer_id');
    }
    
    public function attemptUsers()
    {
        return $this->hasMany(EventAttempt::class, 'event_id', 'id');
    }
    
    public function getPersonalStatus(): bool
    {
        return $this->personalStatus;
    }
    
    public function setPersonalStatus(bool $personalStatus)
    {
        $this->personalStatus = $personalStatus;
    }
}
