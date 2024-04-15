<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Element;

class ElementController extends Controller
{
    public function show_all(Request $request, $group_elements_id, $levels_id)
    {
        $elements = Element::where("level_id", $levels_id)->get();
        return $elements;
    }

    public function store(Request $request)
    {
        try {
            $element = new Element();
            $element->name = $request->input("name");
            $element->level_id = $request->input("level_id");
            $element->link = $request->input("link");
            $element->save();

            return response("Ok", 200);
        } catch (\Exception $e) {
            return response('Bad request:' . $e->getMessage(), 400);
        }
    }
}
