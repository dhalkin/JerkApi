<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ORM\Model\Dance\Company;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['welcome']]);
        
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
                "companyUid" => $company->uid,
                "companyName"=> $company->name,
                "userName"=> $user->first_name . ' ' . $user->last_name,
                "apiToken"=> base64_encode($user->api_token),
                "title" => $company->name . " - " . trans('auth.management'),
                "companyTimezone" => $company->timezone
            ]);
    }
    
    public function welcome()
    {
        
        $companies = Company::where('public_available', true)->get();
    
        return view('welcome',
            [
                "companies" => $companies
            ]);
    }
}
