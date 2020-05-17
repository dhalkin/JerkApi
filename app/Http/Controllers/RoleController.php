<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ORM\Model\Dance\Role;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    
    public function get(Request $request)
    {
        $roles = Role::all();
        
        return response()->json(RoleResource::collection($roles), '200');
    }
    
    
    public function update(Request $request)
    {
        $role = Role::find($request->get('id'));
        $changes = $request->all();
    
        if ($role) {
            unset($changes['id']);
        
            foreach ($changes as $item => $val) {
                $role->$item = $val;
            }
        
            $role->save();
        } else {
            $role = new Role();
            foreach ($changes as $item => $val) {
                $role->$item = $val;
            }
        
            $role->save();
        
            return response()->json(['id' => $role->id], '200');
        }
    }
    
    public function delete(Request $request)
    {
        $role = Role::find($request->get('id'));
        $role->delete();
    }
}
