<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function index(Request $request)
    {
        $company = $request->user()->company;
        
        return $company->halls;
        
    }
    
}
