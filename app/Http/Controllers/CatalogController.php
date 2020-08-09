<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ORM\Model\Timezone;

class CatalogController extends Controller
{


    public function timezones()
    {

        return Timezone::all();

    }
    
    public function olala()
    {
        $arr1 = [
            "foo" => "bar",
            "bar" => "foo",
            100   => -100,
            -100  => 100
        ];
        $arr2 = [
            "foo" => "bar2",
            "bar" => "foo2",
            100   => -101,
            -100  => 101,
            -200  => 201
        ];
    
        $result = $arr1 + $arr2;
        
        $putdata =fopen("php://input","r");
    
        
        $fp=fopen("myputfile.txt","w");
        
        while($data = fread($putdata,1024))
        fwrite($fp,$data);
        
        fclose($fp);
        fclose($putdata);

        return response()->json([
            'result' => $result,
            'putdata' => ''
        ], '200');
    }

}
