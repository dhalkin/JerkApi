<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        return $request->user()->toJson();
    }

    public function storeCompany(Request $request)
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
