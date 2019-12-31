<?php

namespace App\Http\Controllers;

use App\ORM\Model\Company;
use App\ORM\Model\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Transformers\CalendarTransformer;

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
        
        $data['csrf'] = $request->session()->token();
        $data['events'] = $events;
        
        // prepare
        
        
        return response()->json($data);
        return (new CalendarTransformer())->transform($user);
    }

}
