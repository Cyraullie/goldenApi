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

    public function show($element_id){
        $element = Element::find($element_id);
        return $element;
    }

    public function update(Request $request, $id)
    {
        try {
            // Récupérer l'élément à mettre à jour
            $element = Element::findOrFail($id);

            // Vérifier s'il y a des changements dans les données reçues
            $name = $request->input("name");
            $link = $request->input("link");

            // Vérifier si le nom a été fourni et s'il est différent du nom actuel
            if ($name !== null && $element->name !== $name) {
                // Mettre à jour le nom de l'élément
                $element->name = $name;
            }

            // Vérifier si le lien a été fourni et s'il est différent du lien actuel
            if ($link !== null && $element->link !== $link) {
                // Mettre à jour le lien de l'élément
                $element->link = $link;
            }

            // Enregistrer les modifications
            $element->save();

            // Retourner une réponse de succès
            return response("L'élément a été mis à jour avec succès.", 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response("Erreur lors de la mise à jour de l'élément : " . $e->getMessage(), 400);
        }
    }


}
