<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ORM\Model\Company;

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

        Company::where('user_id', $request->user()->id)
            ->update([
                'name' => $request->get('name'),
                'address' => $request->get('address'),
                'city' => $request->get('city'),
                'country' => $request->get('country'),
                'zip' => $request->get('zip'),
                'about' => $request->get('about'),
                'timezone' => $request->get('timezone'),
            ]);

    }
}
