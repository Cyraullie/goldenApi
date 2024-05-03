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

    public function show($level_id){
        $level = Level::find($level_id);
        return $level["name"];
    }

    public function delete($id)
    {
        try {
            // Trouver le niveau à supprimer
            $level = Level::findOrFail($id);

            // Charger les éléments (elements) liés à ce niveau
            $level->load('elements.variations.state_elements');

            // Parcourir chaque élément et supprimer ses variations et state_elements
            $level->elements->each(function ($element) {
                $element->variations->each(function ($variation) {
                    $variation->state_elements()->delete();
                    $variation->delete();
                });
                $element->delete();
            });

            // Enfin, supprimer le niveau lui-même
            $level->delete();

            // Réponse de succès
            return response("Le niveau et ses éléments associés ont été supprimés avec succès.", 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response("Erreur lors de la suppression du niveau : " . $e->getMessage(), 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Récupérer le niveau à mettre à jour
            $level = Level::findOrFail($id);

            // Vérifier s'il y a des changements dans les données reçues
            $name = $request->input("name");

            // Vérifier si le nom a été fourni et s'il est différent du nom actuel
            if ($name !== null && $level->name !== $name) {
                // Mettre à jour le nom du niveau
                $level->name = $name;
                // Enregistrer les modifications
                $level->save();
                // Retourner une réponse de succès
                return response("Le niveau a été mis à jour avec succès.", 200);
            } else {
                // Si aucun changement n'a été effectué, retourner une réponse appropriée
                return response("Aucune modification n'a été apportée.", 200);
            }
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response("Erreur lors de la mise à jour du niveau : " . $e->getMessage(), 400);
        }
    }


}
