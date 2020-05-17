<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Http\Resources\ColorResource;
use App\Http\Resources\TrainerResource;
use Illuminate\Http\Request;
use App\ORM\Model\Dance\Group;
use App\ORM\Model\Dance\Company;
use App\ORM\Model\Color;
use App\ORM\Model\Dance\Role;
use App\ORM\Model\Dance\CompanyUser;

class GroupController extends Controller
{
    /*
     * list of groups
     */
    public function getGroups(Request $request, $uid)
    {
        $c = Company::where('uid', $uid)->firstOrFail();
        $groups = Group::where('company_id', $c->getId())->get();
        
        return response()->json(GroupResource::collection($groups), '200');
    }
    
    /*
     *  group
     * is there any future events?
     */
    public function getGroup(Request $request, $companyUid, $groupUid)
    {
        $c = Company::where('uid', $companyUid)->firstOrFail();
        if ($groupUid != 'new') {
            $group = Group::where('uid', $groupUid)->firstOrFail();
        }
        
        $colors = Color::all();
        $trainers = CompanyUser::where([
            ['company_id', '=', $c->getId()],
            ['role_id', '=', Role::ROLE_TRAINER]
        ])->get();
        
        return response()->json([
            'group' => (isset($group)) ? $group->toArray() : ['name'=>'', 'color_id'=>1, 'max_person'=>'1', 'duration_min'=> 90, 'default_trainer_id'=>'', 'about'=>''],
            'colors' => ColorResource::collection($colors),
            'trainers' => TrainerResource::collection($trainers)
        ], '200');
    }
    
    /*
     * save group
     */
    public function saveGroup(Request $request, $companyUid)
    {
        $c = Company::where('uid', $companyUid)->firstOrFail();
    
        $this->validate($request, [
            'name' => 'required',
            'max_person' => 'required|numeric',
            'duration_min' => 'required|numeric',
            'color_id' => 'required|numeric'
        ]);
        
        $uid =  $request->get('uid');
        if ($uid) {
            $group = Group::where('uid', $uid)->firstOrFail();
        } else {
            $group = new Group();
        }
    
        $group->name = $request->get('name');
        $group->max_person = $request->get('max_person');
        $group->duration_min = $request->get('duration_min');
        $group->company_id = $c->getId();
        $group->color_id = $request->get('color_id');
        $group->default_trainer_id = $request->get('default_trainer_id');
        $group->about = $request->get('about');
        
        $group->save();
        
    }
    
    /*
     * del
     */
    public function deleteGroup(Request $request)
    {
        $group = Group::where('uid', $request->get('uid'))->firstOrFail();
        $group->delete();
    }
}
