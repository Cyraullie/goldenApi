<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variation;
use App\Models\Athlete;
use App\Models\GroupAthlete;
use App\Models\StateElement;
use App\Models\Element;

class VariationController extends Controller
{
    public function show_all(Request $request, $group_elements_id, $levels_id, $elements_id)
    {
        $array = [];
        $array[0] = Variation::where("element_id", $elements_id)->get();
        $array[1] = Athlete::with("stateElements")->get();
        $array[2] = GroupAthlete::all();
        $array[3] = Element::find($elements_id);

        return $array;
    }

    public function show($variation_id){
        $variation = Variation::find($variation_id);
        return $variation["name"];
    }
    
    public function store(Request $request)
    {
        try {
            $variation = new Variation();
            $variation->name = $request->input("name");
            $variation->element_id = $request->input("element_id");
            $variation->save();

            return response("Ok", 200);
        } catch (\Exception $e) {
            return response('Bad request:' . $e->getMessage(), 400);
        }
    }

    public function delete($id)
    {
        try {
            // Trouver la variation à supprimer
            $variation = Variation::findOrFail($id);

            // Supprimer tous les state_elements associés à cette variation
            $variation->state_elements()->delete();

            // Enfin, supprimer la variation elle-même
            $variation->delete();

            // Réponse de succès
            return response("La variation et ses state_elements associés ont été supprimés avec succès.", 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response("Erreur lors de la suppression de la variation : " . $e->getMessage(), 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Récupérer la variation à mettre à jour
            $variation = Variation::findOrFail($id);

            // Vérifier s'il y a des changements dans les données reçues
            $name = $request->input("name");

            // Vérifier si le nom a été fourni et s'il est différent du nom actuel
            if ($name !== null && $variation->name !== $name) {
                // Mettre à jour le nom de la variation
                $variation->name = $name;
            }

            // Enregistrer les modifications
            $variation->save();

            // Retourner une réponse de succès
            return response("La variation a été mise à jour avec succès.", 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response("Erreur lors de la mise à jour de la variation : " . $e->getMessage(), 400);
        }
    }

}

