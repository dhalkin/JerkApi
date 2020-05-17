<?php

namespace App\Http\Controllers;

use App\ORM\Model\Dance\Hall;
use Illuminate\Http\Request;
use App\ORM\Model\Dance\Branch;
use App\ORM\Model\Dance\Company;
use App\Http\Resources\BranchResource;

class BranchController extends Controller
{
    /*
     * get branches
     */
    public function get(Request $request, $uid)
    {
        $c = Company::where('uid', $uid)->firstOrFail();
        $branches = Branch::with('halls')->where('company_id', $c->getId())->get();
        
        return response()->json(BranchResource::collection($branches), '200');
    }
    
    /*
     * update, new branch
     */
    public function update(Request $request, $uid)
    {
        $changes = $request->all();
        $c = Company::where('uid', $uid)->firstOrFail();
    
        if (isset($changes['uid'])) {
            $branch = Branch::where('uid', $request->get('uid'))->firstOrFail();
        } else {
            $branch = new Branch();
            $new = true;
        }
    
        unset($changes['uid']);
        foreach ($changes as $item => $val) {
            $branch->$item = $val;
        }
    
        $branch->company_id = $c->getId();
        $branch->save();
    
        if (isset($new)) {
            return response()->json(['uid' => $branch->getUid()], '200');
        }
        
    }
    
    
    /*
     * delete branch
     * what if deleted branch has a halls?
     */
    public function delete(Request $request)
    {
        $branch = Branch::where('uid', $request->get('uid'))->firstOrFail();
        $branch->delete();
    }
    
    /*
     * to get data for complex UI branch with relations
     */
    public function getBranchByUid(Request $request, $uid)
    {
        $branch = Branch::with(['halls'])->where('uid', $uid)->get();
    
        return response()->json(BranchResource::collection($branch), '200');
    }
    
    /*
     * the branch has children wich is halls
     * let deal here with it
     *
     */
    public function updateHall(Request $request, $uid)
    {
        $changes = $request->all();
        $branch = Branch::where('uid', $uid)->firstOrFail();
        
        if (isset($changes['uid'])) {
            $hall = Hall::where('uid', $changes['uid'])->firstOrFail();
        }else{
            $hall = new Hall();
            $new = true;
        }
        
        foreach ($changes as $item => $val) {
            $hall->$item = $val;
        }
        $hall->branch_id = $branch->getId();
        $hall->save();
    
        if (isset($new)){
            return response()->json(['uid' => $hall->getUid()], '200');
        }
    }
    
    /*
     * is there any future events in deleted hall?
     */
    public function deleteHall(Request $request) {
        
        $hall = Hall::where('uid', $request->get('uid'))->firstOrFail();
        $hall->delete();
    }
    
}
