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

    public function delete($id)
    {
        try {
            // Trouver l'élément à supprimer
            $element = Element::findOrFail($id);

            // Charger les variations (variations) liées à cet élément
            $element->load('variations.state_elements');

            // Parcourir chaque variation et supprimer ses state_elements
            $element->variations->each(function ($variation) {
                $variation->state_elements()->delete();
                $variation->delete();
            });

            // Enfin, supprimer l'élément lui-même
            $element->delete();

            // Réponse de succès
            return response("L'élément et ses variations associées ont été supprimés avec succès.", 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response("Erreur lors de la suppression de l'élément : " . $e->getMessage(), 400);
        }
    }

}
