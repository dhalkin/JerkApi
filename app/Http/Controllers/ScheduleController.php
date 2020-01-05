<?php

namespace App\Http\Controllers;

use App\ORM\Model\Company;
use App\ORM\Model\Event;
use App\ORM\Model\EventCompanyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Resources\EventResource;

class ScheduleController extends Controller
{
    
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
    
    
    public function show(Request $request, $uniqueId)
    {
        $company = Company::where('unique_id', '=', $uniqueId)
            ->firstOrFail();
        
        return view('schedule',
            [
                "companyUid" => $uniqueId,
                "title" => $company->name . ' - ' . trans('timetable'),
                "companyName"=> $company->name
            ]);
    }
    
    
    public function events(Request $request)
    {
        $data = [];
    
        $now =  Carbon::now();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        
        $events = Event::with(['group','hall'])->where('start', '>=', $weekStart)
            ->where('finish', '<=', $weekEnd)->get();
    
        $user = Auth::guard('web2')->user();
        if($user){
            // check user attempts
            $eventIds=[];
            foreach ($events as $event){
                $eventIds[] = $event->id;
            }
    
            $res = EventCompanyUser::select('event_id')->whereIn('event_id', $eventIds)
                ->where('company_user_id', $user->id)->get()->toArray();
    
            $res = array_column($res, 'event_id');
            foreach ($events as $event){
                
                if(in_array($event->getAttribute('id'), $res)){
                    $event->setPersonalStatus(true);
                }
                
            }
        }
        
        $data['csrf'] = $request->session()->token();
        $data['events'] = $events;
        
        return EventResource::collection($events);
    }
    
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
        
        $eventCompanyUser = EventCompanyUser::where('event_id', '=', $eventId)
            ->where('company_user_id', '=', $user->id)
            ->first();
        
        $checked =  $request->get('checked');
        if($checked){
            // remove
            if($eventCompanyUser){
                if($eventCompanyUser->delete()){
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
    
            if($eventCompanyUser){
                return response()->json([
                    'message' => trans('auth.already_attempt'),
                    'type' => 'warning'
                ], 409);
            }
            
            $eventCompanyUser = new EventCompanyUser([
                'event_id' => $eventId,
                'company_user_id' => $user->id
            ]);
    
            // and login in a hurry
            if ($eventCompanyUser->save()) {
                return response()->json([
                    'message' => 'Success',
                    'type' => 'success'
                ], 200);
            }
        }
    }
}
