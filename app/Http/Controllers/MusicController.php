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
       // return response($request->file('image'), 200);

        
        if ($imagefile = $request->file('image')) {
              // Générez un nom de fichier unique
            $fileName = $request->input('name') . '.' . $imagefile->getClientOriginalExtension(); // Par exemple, timestamp + extension du fichier

            // Déplacez le fichier temporaire vers le répertoire de stockage définitif en utilisant le nouveau nom de fichier
            $imagefile->move(public_path('musics'), $fileName); // Assurez-vous que 'musics' est le bon répertoire de stockage
            
            $musicfile = $request->file('music');
                // Générez un nom de fichier unique
            $musicfileName = $request->input('name') . '.' . $musicfile->getClientOriginalExtension(); // Par exemple, timestamp + extension du fichier

            // Déplacez le fichier temporaire vers le répertoire de stockage définitif en utilisant le nouveau nom de fichier
            $musicfile->move(public_path('musics'), $musicfileName); // Assurez-vous que 'musics' est le bon répertoire de stockage
            
            $music = new Music();
            $music->name = $request->input("name");
            $music->filename = $musicfileName;
            $music->save();

            return response('Ok',200);
        } else {
            return response('Bad request',400);
        }
        
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
