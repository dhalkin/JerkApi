<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use Illuminate\Http\Request;
use App\ORM\Model\Dance\Group;
use App\ORM\Model\Dance\Company;

class GroupController extends Controller
{
    public function getGroups(Request $request, $uid)
    {
        $c = Company::where('uid', $uid)->firstOrFail();
        $groups = Group::where('company_id', $c->getId())->get();
        
        return response()->json(GroupResource::collection($groups), '200');
    }
}
