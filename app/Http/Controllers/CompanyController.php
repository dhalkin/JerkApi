<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ORM\Model\Dance\Company;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        $company = $request->user()->company;
        
        return $company->toJson();
    }

    
    public function storeCompany(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'zip' => 'numeric'
        ]);
        
        $uid = $request->get('uid');

        Company::where('user_id', $request->user()->id)
            ->update([
                'name' => $request->get('name'),
                'address' => $request->get('address'),
                'city' => $request->get('city'),
                'country' => $request->get('country'),
                'zip' => $request->get('zip'),
                'rules' => $request->get('rules'),
                'about' => $request->get('about'),
                'timezone' => $request->get('timezone'),
                'last_call_hours' => $request->get('last_call_hours'),
                'refuse_in_hours' => $request->get('refuse_in_hours'),
                'public_available' => $request->get('public_available')
                
            ]);

    }
}
