<?php

namespace App\Http\Controllers;

use App\ORM\Model\Dance\Company;
use App\ORM\Model\Dance\Event;
use App\ORM\Model\Dance\EventAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Resources\EventResource;

class ScheduleController extends Controller
{
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function session(Request $request)
    {
        $data = [];
        
        if($user = Auth::guard('web2')->user())
        {
            $data['apiToken'] = $user->getAttributes()['api_token'];
            $data['userName'] = $user->getAttributes()['first_name'];
        }
        $data['csrf'] = $request->session()->token();
        
        return response()->json($data);
    }
    
    
    /**
     * @param Request $request
     * @param $uniqueId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $uniqueId)
    {
        $company = Company::where('unique_id', '=', $uniqueId)
            ->firstOrFail();
        
        return view('schedule',
            [
                "companyUid" => $uniqueId,
                "title" => $company->name . ' - ' . trans('auth.timetable'),
                "companyName"=> $company->name,
                "companyTimezone"=> $company->timezone
            ]);
    }
    
    
    /**
     * @param Request $request
     * @param companyId $companyId
     *
     * @return json
     */
    public function events(Request $request, $companyId)
    {
        $data = [];
    
        $now =  Carbon::now();
        $weekStart = $request->get('start'); //Carbon::now()->startOfWeek();
        $weekEnd = $request->get('stop'); //Carbon::now()->endOfWeek();
        $company = Company::where('unique_id', $companyId)->firstOrFail();
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
    
        $user = Auth::guard('web2')->user();
        if($user){
            // check user attempts
            $eventIds=[];
            foreach ($events as $event){
                $eventIds[] = $event->id;
            }
    
            $res = EventAttempt::select('event_id')->whereIn('event_id', $eventIds)
                ->where('company_user_id', $user->id)->get()->toArray();
    
            $res = array_column($res, 'event_id');
            foreach ($events as $event){
                if(in_array($event->getAttribute('id'), $res)){
                    $event->setPersonalStatus(true);
                }
            }
        }
       
        $data['events'] = EventResource::collection($events);
        $data['csrf'] = $request->session()->token();
        
        return response()->json($data, '200');
    }
    
    /**
     * @param Request $request
     * @param $uniqueId
     * @return \Illuminate\Http\JsonResponse
     */
    public function attemptToJoin(Request $request, $uniqueId)
    {
        // get user
        $user = Auth::guard('web2')->user();
        if(!$user){
            return response()->json([
                'message' => trans('auth.only_logged'),
                'type' => 'warning'
            ], 409);
        }
        
        $company = Company::where('unique_id', '=', $uniqueId)
            ->firstOrFail();
        $eventId = $request->get('eventId');
        
        $eventAttempt = EventAttempt::where('event_id', '=', $eventId)
            ->where('company_user_id', '=', $user->id)
            ->first();
        
        $checked =  $request->get('checked');
        if($checked){
            // remove
            if($eventAttempt){
                $trash = EventAttempt::where('event_id', '=', $eventId)
                    ->where('company_user_id', '=', $user->id)
                    ->delete();
                
                if($trash){
                    return response()->json([
                        'message' => 'Success',
                        'type' => 'success'
                    ], 200);
                }
            
            }else{
                return response()->json([
                    'message' => trans('auth.already_attempt'),
                    'type' => 'warning'
                ], 409);
            }
            
        }else{
            // attempt
            if($eventAttempt){
                return response()->json([
                    'message' => trans('auth.already_attempt'),
                    'type' => 'warning'
                ], 409);
            }
            
            $eventAttempt = new EventAttempt([
                'event_id' => $eventId,
                'company_user_id' => $user->id
            ]);
            
            if ($eventAttempt->save()) {
                return response()->json([
                    'message' => 'Success',
                    'type' => 'success'
                ], 200);
            }
        }
    }
    
    
    /**
     * @param Request $request
     * @param $companyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function environment(Request $request, $companyId)
    {
        $apiToken = null;
        $userName = null;
        $user = Auth::guard('web2')->user();
        if ($user) {
            $apiToken = $user->getAttributes()['api_token'];
            $userName = $user->getAttributes()['first_name'];
        }
        
        $company = Company::select('id', 'last_call_hours', 'refuse_in_hours', 'rules')
            ->with(['branches'])->where('unique_id', '=', $companyId)
            ->firstOrFail();
    
        $company->rules = nl2br($company->rules);
        return response()->json([
            'company' => $company,
            'apiToken'=> $apiToken,
            'userName'=> $userName,
            'type' => 'success'
        ], 200);
    }
    
}
