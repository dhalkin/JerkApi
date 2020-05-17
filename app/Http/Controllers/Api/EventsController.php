<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EventResource;
use App\ORM\Model\Dance\Company;
use App\ORM\Model\Dance\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
    /*
     * list of users
     */
    public function getEvents(Request $request, $uid)
    {
        $data = [];
    
        $now =  Carbon::now();
        $weekStart = $request->get('start'); //Carbon::now()->startOfWeek();
        $weekEnd = $request->get('stop'); //Carbon::now()->endOfWeek();
        $company = Company::with('branches')->where('uid', $uid)->firstOrFail();
        $data['company'] = [
            'lastCallHours' => $company->last_call_hours,
            'refuseInHours' => $company->refuse_in_hours
        ];
        $data['branches'] = $company->branches;
        
        $currentBranch =  $request->get('currentBranch');
        $eventsQ = Event::where('dance_events.company_id', '=', $company->id)
            ->where('dance_events.start', '>=', $weekStart)
            ->where('dance_events.finish', '<=', $weekEnd)
            ->where('dance_events.active', '=', true);
    
        if ($currentBranch > 0) {
            $eventsQ->leftJoin('dance_halls', 'dance_events.hall_id', '=', 'dance_halls.id')
                ->leftJoin('dance_branches', 'dance_halls.branch_id', '=', 'dance_branches.id')
                ->where('dance_halls.branch_id', $currentBranch);
        }
    
        $events = $eventsQ->select('dance_events.*')->get();
    
        $data['events'] = EventResource::collection($events);
        
        return response()->json($data, '200');
    }
}
