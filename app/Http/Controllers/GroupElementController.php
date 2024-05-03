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

    public function show($group_element_id){
        $groupElement = GroupElement::find($group_element_id);
        return $groupElement["name"];
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

    public function update(Request $request, $id)
    {
        try {
            // Récupérer le groupElement à mettre à jour
            $groupElement = GroupElement::findOrFail($id);

            // Vérifier s'il y a des changements dans les données reçues
            $name = $request->input("name");

            // Vérifier si le nom a été fourni et s'il est différent du nom actuel
            if ($name !== null && $groupElement->name !== $name) {
                // Mettre à jour le nom du groupElement
                $groupElement->name = $name;
                // Enregistrer les modifications
                $groupElement->save();
                // Retourner une réponse de succès
                return response("Le groupElement a été mis à jour avec succès.", 200);
            } else {
                // Si aucun changement n'a été effectué, retourner une réponse appropriée
                return response("Aucune modification n'a été apportée.", 200);
            }
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response("Erreur lors de la mise à jour du groupElement : " . $e->getMessage(), 400);
        }
    }

}
