<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        return $request->user()->company;
    }

    public function storeCompany(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'location' => 'required'
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
