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
        if($user = Auth::user())
        {
            $data['apiToken'] = $user->getAttributes()['api_token'];
        }
        $data['csrf'] = $request->session()->token();
        
        return response()->json($data);
    }
    
    
    public function show(Request $request, $uniqueId)
    {
        return view('schedule', ["company" => $uniqueId, "title"=>"Danilova Dance - Timetable"]);
    }

}
