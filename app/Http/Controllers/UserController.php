<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ORM\Model\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function session(Request $request)
    {
        $user = Auth::guard('web')->user();
    
        return $request->user()->toJson();
    }
    
    public function storeProfile(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'email' => 'email|required'
        ]);
    
        User::where('id', $request->user()->id)
            ->update([
                'first_name' => $request->get('first_name'),
                'second_name' => $request->get('second_name'),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
            ]);
        
    }
}
