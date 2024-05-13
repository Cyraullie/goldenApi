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
            $music->image_filepath = $fileName;
            $music->save();

            return response('Ok',200);
        } else {
            return response('Bad request',400);
        }
    }

    public function delete($id)
    {
        try {
            // Trouver l'athlète à supprimer
            $music = Music::findOrFail($id);
    
            $filePathMusic = public_path('musics/' . $music->image_filepath);
            if (file_exists($filePathMusic)) {
                unlink($filePathMusic);
            }

            $filePathImage = public_path('music/' . $music->filename);
            if (file_exists($filePathImage)) {
                unlink($filePathImage);
            }

            $music->delete();
    
            // Réponse de succès
            return response("La musique a été supprimé avec succès.", 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response("Erreur lors de la suppression de la musique : " . $e->getMessage(), 400);
        }
    }
}
