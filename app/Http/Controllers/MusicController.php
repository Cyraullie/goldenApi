<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Music;

class MusicController extends Controller
{
    public function show_all()
    {
        $musics = Music::all();
        return $musics;
    }

    public function store(Request $request)
    {
        return response($request, 200);
        /*
        try {
            $level = new Level();
            $level->name = $request->input("name");
            $level->group_element_id = $request->input("group_element_id");
            $level->save();

            return response("Ok", 200);
        } catch (\Exception $e) {
            return response('Bad request:' . $e->getMessage(), 400);
        }*/
    }
}
