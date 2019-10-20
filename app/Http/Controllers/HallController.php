<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Hall;

class HallController extends Controller
{
    public function index(Request $request)
    {
        $company = $request->user()->company;
        
        return $company->halls;
        
    }
    
    public function getHall($uuid)
    {
        //@todo user rights
        return Hall::where('unique_id', '=', $uuid)
            ->firstOrFail()
            ->toJson();
    }
    
    public function createHall(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required'
        ]);
        
        $hall = new Hall();
        $hall->name = $request->get('name');
        $hall->address = $request->get('address');
    
        $company = $request->user()->company;
        $hall->company_id = $company->id;
        $company->halls()->save($hall);
    
        return response()->json( ['uuid'=> $hall->unique_id]);
    }
    
    public function updateHall(Request $request, $uuid)
    {
        //@todo user rights, update mechanizm
    
        Hall::where('unique_id', $uuid)
            ->update([
                'active' => $request->get('active')
            ]);
    }
    
}
