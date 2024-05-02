<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Athlete;

class AthleteController extends Controller
{
    public function show_all()
    {
        $athletes = Athlete::all();
        return $athletes;
    }

    
    public function store(Request $request)
    {
        try {
            $athlete = new Athlete();
            $athlete->firstname = $request->input("firstname");
            $athlete->group_athlete_id1 = $request->input("group1");
            $athlete->group_athlete_id2 = $request->input("group2");
            $athlete->save();

            return response("Ok", 200);
        } catch (\Exception $e) {
            return response('Bad request:' . $e->getMessage(), 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Récupérer l'athlète à mettre à jour
            $athlete = Athlete::findOrFail($id);
    
            // Vérifier s'il y a des changements
            $firstname = $request->input("firstname");
            $group1 = $request->input("group1");
            $group2 = $request->input("group2");
    
            $changes = false;
    
            if ($firstname !== null && $athlete->firstname !== $firstname) {
                $athlete->firstname = $firstname;
                $changes = true;
            }
    
            if ($group1 !== "vide" && $group1 !== "aucun" && $athlete->group_athlete_id1 != $group1) {
                $athlete->group_athlete_id1 = $group1;
                $changes = true;
            } elseif ($group1 === "aucun") { // Si le groupe1 est null ou égal à zéro, supprimer le groupe
                $athlete->group_athlete_id1 = null;
                $changes = true;
            }
    
            if ($group2 !== "vide" && $group2 !== "aucun" && $athlete->group_athlete_id2 != $group2) {
                $athlete->group_athlete_id2 = $group2;
                $changes = true;
            } elseif ($group2 === "aucun") { // Si le groupe2 est null ou égal à zéro, supprimer le groupe
                $athlete->group_athlete_id2 = null;
                $changes = true;
            }
    
            // Si aucun changement, retourner une réponse appropriée
            if (!$changes) {
                return response("No changes", 200);
            }
    
            // Si des changements ont été effectués, sauvegarder et retourner une réponse OK
            $athlete->save();
            return response("Ok", 200);
        } catch (\Exception $e) {
            return response('Bad request:' . $e->getMessage(), 400);
        }
    }
    
    public function delete($id)
    {
        try {
            // Trouver l'athlète à supprimer
            $athlete = Athlete::findOrFail($id);
    
            $athlete->stateElements()->delete();
            // Supprimer l'athlète de la base de données
            $athlete->delete();
    
            // Réponse de succès
            return response("L'athlète a été supprimé avec succès.", 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur
            return response("Erreur lors de la suppression de l'athlète : " . $e->getMessage(), 400);
        }
    }
    

}
