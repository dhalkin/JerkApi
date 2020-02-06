<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $company = $request->user()->company;
        $user = Auth::guard('web')->user();
        
        return view('home',
            [
                "companyUid" => $company->unique_id,
                "companyName"=> $company->name,
                "userName"=> $user->first_name . ' ' . $user->last_name,
                "apiToken"=> base64_encode($user->api_token),
                "title" => $company->name . " - " . trans('auth.management')
            ]);
    }
}
