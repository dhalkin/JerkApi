<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ORM\Model\Dance\Branch;
use App\Http\Resources\BranchResource;

class BranchController extends Controller
{

    public function get(Request $request)
    {
        $branches = Branch::all();
    
        return response()->json(BranchResource::collection($branches), '200');
    }
    
    
    public function update(Request $request)
    {
        $branch = Branch::find($request->get('id'));
        $changes = $request->all();
        
        if($branch){
            unset($changes['id']);
            
            foreach ($changes as $item => $val){
                $branch->$item = $val;
            }
            
            $branch->save();
        } else {
            $branch = new Branch();
            foreach ($changes as $item => $val){
                $branch->$item = $val;
            }
    
            $branch->save();
        }
    }
    
    public function delete(Request $request)
    {
        $branch = Branch::find($request->get('id'));
        $branch->delete();
    }
}
