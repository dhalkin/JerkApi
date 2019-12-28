<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class FakeController extends BaseController
{
    
    protected function login()
    {
        return redirect()->back();
    }
}
