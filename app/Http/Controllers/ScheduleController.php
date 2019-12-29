<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        
        $data['csrf'] = $request->session()->token();
    
        
        return response()->json($data);
    }

}
