<?php

namespace App\ORM\Model;

use Illuminate\Database\Eloquent\Model;

class EventAttempt extends Model
{
    public $timestamps = true;
    protected $table = 'event_attempts';
    
    protected $fillable = ['event_id', 'company_user_id'];
    
    
    
    public function isUserPresentOnEvent($eventId, $companyUserId)
    {
        return self::where('event_id', $eventId)
            ->where('company_user_id', $companyUserId)->first() ? true : false;
    }
}
