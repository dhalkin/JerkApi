<?php

namespace App\Http\Controllers;

use App\ORM\Model\Company;
use App\ORM\Model\Event;
use App\ORM\Model\EventAttempt;
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
                "title" => $company->name . ' - ' . trans('timetable'),
                "companyName"=> $company->name,
                "companyTimezone"=> $company->timezone
            ]);
    }
    
    
    /**
     * @param Request $request
     * @param companyId $companyId
     */
    public function events(Request $request, $companyId)
    {
        $data = [];
    
        $now =  Carbon::now();
        $weekStart = $request->get('start'); //Carbon::now()->startOfWeek();
        $weekEnd = $request->get('stop'); //Carbon::now()->endOfWeek();
        $company = Company::where('unique_id', $companyId)->firstOrFail();
        $events = Event::with(['group','hall', 'attemptUsers'])->where('start', '>=', $weekStart)
            ->where('finish', '<=', $weekEnd)->get();
    
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
            
            $data['apiToken'] = $user->getAttributes()['api_token'];
            $data['userName'] = $user->getAttributes()['first_name'];
        }
       
        $data['events'] = EventResource::collection($events);
        $data['csrf'] = $request->session()->token();
        $data['companyRules'] = [
            'last_call_hours' => $company->last_call_hours,
            'refuse_in_hours'=>$company->refuse_in_hours,
            'rules'=> nl2br($company->rules)
        ];
        
        return response()->json($data);
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
}
