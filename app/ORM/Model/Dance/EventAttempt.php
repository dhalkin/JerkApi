<?php

namespace App\ORM\Model\Dance;

use Illuminate\Database\Eloquent\Model;

class EventAttempt extends Model
{
    public $timestamps = true;
    protected $table = 'dance_event_attempts';
    
    protected $fillable = ['event_id', 'company_user_id'];
    
    
    
    public function isUserPresentOnEvent($eventId, $companyUserId)
    {
        return self::where('event_id', $eventId)
            ->where('company_user_id', $companyUserId)->first() ? true : false;
    }
}
