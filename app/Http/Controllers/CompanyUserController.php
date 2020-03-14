<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyUserResource;
use App\Http\Resources\RoleResource;
use App\ORM\Model\Dance\Company;
use App\ORM\Model\Dance\CompanyUser;
use App\ORM\Model\Dance\Role;
use Illuminate\Http\Request;

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
}
