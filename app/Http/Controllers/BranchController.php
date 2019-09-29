<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class BranchController extends Controller
{

    public function index(Request $request)
    {
        $company = $request->user()->company;
        
        return $company->branches;
        
    }

    public function storeCompany(Request $request)
    {

        $this->validate($request, [
            'name' => 'required'
        ]);

        Company::where('user_id', $request->user()->id)
            ->update([
                'name' => $request->get('name'),
                'location' => $request->get('location'),
                'email' => $request->get('email'),
                'timezone' => $request->get('timezone')
            ]);

    }
}
