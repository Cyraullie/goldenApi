<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupElement;

class GroupElementController extends Controller
{
    public function show_all()
    {
        $groupElems = GroupElement::all();
        return $groupElems;
    }

    
    public function store(Request $request)
    {
        try {
            $groupElement = new GroupElement();
            $groupElement->name = $request->input("name");
            $groupElement->save();

            return response("Ok", 200);
        } catch (\Exception $e) {
            return response('Bad request:' . $e->getMessage(), 400);
        }
        
    }

    public function show($group_elements_id){
        $groupElement = GroupElement::find($group_elements_id);
        return strtoupper($groupElement["name"]);
    }
}
