<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Timezone;

class CatalogController extends Controller
{


    public function timezones()
    {

        return Timezone::all();

    }

}
