<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\GroupElement;

class LevelController extends Controller
{
    public function show_all(Request $request, $group_elements_id)
    {
        $levels = Level::where("group_element_id", $group_elements_id)->get();
        return $levels;
    }

    public function store(Request $request)
    {
        try {
            $level = new Level();
            $level->name = $request->input("name");
            $level->group_element_id = $request->input("group_element_id");
            $level->save();

            return response("Ok", 200);
        } catch (\Exception $e) {
            return response('Bad request:' . $e->getMessage(), 400);
        }
    }

    public function show($group_elements_id, $levels_id){
        $level = Level::find($levels_id);
        $groupElement = GroupElement::find($group_elements_id);
        
        $array = [strtoupper($groupElement["name"]), strtoupper($level["name"])];

        return $array;
    }
}
