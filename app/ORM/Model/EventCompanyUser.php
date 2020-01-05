<?php

namespace App\ORM\Model;

use Illuminate\Database\Eloquent\Model;

class EventCompanyUser extends Model
{
    
    public $timestamps = false;
    protected $hidden = ['id'];
    protected $table = 'events_company_users';
    
    protected $fillable = ['event_id', 'company_user_id'];
    
    public function isUserPresentOnEvent($eventId, $companyUserId)
    {
        return self::where('event_id', $eventId)
            ->where('compamy_user_id', $companyUserId)->first() ? true : false;
    }
}
