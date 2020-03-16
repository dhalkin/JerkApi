<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyUserResource;
use App\ORM\Model\Dance\Company;
use App\ORM\Model\Dance\CompanyUser;
use App\ORM\Model\Dance\Role;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyUserController extends Controller
{
    /*
     * list of users
     */
    public function getUsers(Request $request, $uid)
    {
        $c = Company::where('uid', $uid)->firstOrFail();
        $users = CompanyUser::where('company_id', $c->getId());
        //$roles = Role::all();
    
        $role_uid = $request->get('role');
        if ($role_uid) {
            $targetRole = Role::where('uid', $role_uid)->firstOrFail();
            if ($targetRole) {
                $users->where('role_id', $targetRole->getId());
            }
        }
        
        $users = $users->get();
        
        return response()->json([
            'users' => CompanyUserResource::collection($users)
        ], '200');
    }
    
    /*
     * Status user
     */
    public function saveUser(Request $request, $uid)
    {
        $c = Company::where('uid', $uid)->firstOrFail();
    
        // validate ?
        
        try {
            $user = CompanyUser::where('id', $request->get('id'))->firstOrFail();
            if ($request->has('active')) {
                $user->active = $request->get('active');
            } else {
                $user->first_name = $request->get('first_name');
                $user->second_name = $request->get('second_name');
                $user->email = $request->get('email');
                $user->phone = $request->get('phone');
                $user->role_id = $request->get('role_id');
            }
            
        }catch (ModelNotFoundException $e){
            
            $user = new CompanyUser();
            $user->company_id = $c->getId();
            $user->first_name = $request->get('first_name');
            $user->second_name = $request->get('second_name');
            $user->email = $request->get('email');
            $user->phone = $request->get('phone');
            $user->role_id = $request->get('role_id');
            
        }
    
        $user->save();
    }
    
    /*
     *
     */
    public function deleteUser() {
    
    }
}
