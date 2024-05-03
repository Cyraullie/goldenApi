<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupElement;

class GroupElementController extends Controller
{
    public function show_all()
    {
        $groupElems = GroupElement::all();
        return $groupElems;
    }

    
    public function store(Request $request)
    {
        try {
            $groupElement = new GroupElement();
            $groupElement->name = $request->input("name");
            $groupElement->save();

            return response("Ok", 200);
        } catch (\Exception $e) {
            return response('Bad request:' . $e->getMessage(), 400);
        }
        
    }

    public function show($group_elements_id){
        $groupElement = GroupElement::find($group_elements_id);
        return strtoupper($groupElement["name"]);
    }

    public function delete($id)
    {
        try {
            // Trouver le groupElement à supprimer
            $groupElement = GroupElement::findOrFail($id);
    
            // Charger les niveaux (levels) liés à ce groupElement
            $groupElement->load('levels');
    
            // Parcourir chaque niveau et supprimer ses éléments et variations
            $groupElement->levels->each(function ($level) {
                // Charger les éléments (elements) liés à ce niveau
                $level->load('elements.variations.state_elements');
    
                // Supprimer toutes les variations et state_elements associés à chaque élément
                $level->elements->each(function ($element) {
                    $element->variations->each(function ($variation) {
                        $variation->state_elements()->delete();
                        $variation->delete();
                    });
                    $element->delete();
                });
    
                // Supprimer le niveau lui-même
                $level->delete();
            });
    
            // Enfin, supprimer le groupElement lui-même
            $groupElement->delete();
            // Réponse de succès
            return response("La technique a été supprimé avec succès.", 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response("Erreur lors de la suppression de la technique : " . $e->getMessage(), 400);
        }
    }
}
