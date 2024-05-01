<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Topicality;


class TopicalityController extends Controller
{
    public function show_all()
    {
        $topicalities = Topicality::all();
        return $topicalities;
    }

    public function show($topic_id)
    {
        $topicality = Topicality::find($topic_id);
        return $topicality;
    }

    public function store(Request $request)
    {
        if ($imagefile = $request->file('image')) {
            $first = mt_rand(0, 9);
            $second = mt_rand(0, 9);
            $third = mt_rand(0, 9);
            $forth = mt_rand(0, 9);

            $rand_num = $first . $second . $third . $forth;

            $fileName = $request->input('name') . $rand_num . '.' . $imagefile->getClientOriginalExtension();

            $imagefile->move(public_path('topicalities'), $fileName); // Assurez-vous que 'musics' est le bon répertoire de stockage
            
            $topicality = new Topicality();
            $topicality->filepath = $fileName;
            $topicality->save();

            return response('Ok',200);
        } else {
            return response('Bad request',400);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $topicality = Topicality::findOrFail($id);
            $oldfilepath = public_path() . "/topicalities/" . $topicality->filepath;
    
            if (file_exists($oldfilepath))
            {
                unlink($oldfilepath);
            }

            if ($imagefile = $request->file('image')) {
                $first = mt_rand(0, 9);
                $second = mt_rand(0, 9);
                $third = mt_rand(0, 9);
                $forth = mt_rand(0, 9);
    
                $rand_num = $first . $second . $third . $forth;
    
                $fileName = $request->input('name') . $rand_num . '.' . $imagefile->getClientOriginalExtension();

                $imagefile->move(public_path('topicalities'), $fileName); 

                $topicality->filepath = $fileName;
        
                $topicality->save();

                return response("Ok", 200);
            }
        } catch (\Exception $e) {
            return response('Bad request:' . $e->getMessage(), 400);
        }
    }

    public function delete($id)
{
    try {
        // Trouver l'actualité à supprimer
        $topicality = Topicality::findOrFail($id);

        // Supprimer le fichier associé à l'actualité
        $filePath = public_path('topicalities/' . $topicality->filepath);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Supprimer l'actualité de la base de données
        $topicality->delete();

        // Réponse de succès
        return response("Le Topic a été supprimée avec succès.", 200);
    } catch (\Exception $e) {
        // En cas d'erreur, retourner une réponse d'erreur
        return response("Erreur lors de la suppression du Topic : " . $e->getMessage(), 400);
    }
}
}
