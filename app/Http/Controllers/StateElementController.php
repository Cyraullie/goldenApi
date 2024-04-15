<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StateElement;

class StateElementController extends Controller
{
    public function update(Request $request)
    {
        $variation_id = $request->input("variation_id");
        $athlete_id = $request->input("athlete_id");
        $newState = $request->input("state");


        $stateExistant = StateElement::where("variation_id", $variation_id)
                                    ->where("athlete_id", $athlete_id)
                                    ->first();
        if($stateExistant){
            //update
            $stateExistant->update([
                "state" => $newState,
            ]);
        }else {
            //insert
            StateElement::create(array_merge(["variation_id" => $variation_id, "athlete_id" => $athlete_id, "state" => $newState]));
        }

        
    }
}
