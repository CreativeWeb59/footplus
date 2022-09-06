<?php

namespace App\Http\Controllers\Api;

use App\Models\Adjust;
use App\Models\Equipe;
use App\Models\Season;
use App\Models\ListeMatch;
use Illuminate\Http\Request;
use App\Models\Historique_equipes;
use App\Http\Controllers\Controller;

class ClassementController extends Controller
{
    public function index()
    {
        $seasons_id = 3;
        
        $classementsNews=ListeMatch::with('equipe1','equipe2')
            ->where([['seasons_id',$seasons_id],['score','<>','-'], ['championnats_id', 1]])
            ->orderBy('date_match', 'desc')
            ->get();

        $listEquipes = Historique_equipes::where([['season_id',$seasons_id],['championnat_id', 1]])
            ->orderBy('equipe_id', 'asc')
            ->pluck('equipe_id');

        $listAdjusts = Adjust::where([['seasons_id',$seasons_id], ['championnats_id', 2]])
            ->orderBy('equipe_id', 'asc')
            ->get();

        $classements = calcul_classement($classementsNews, $listEquipes, $listAdjusts); 

        // traitement pour le champ nom vide quand pas de stats
        $listeNoms = 'nom equipe';

        
    // Permet d'ajouter le nom de l'équipe quand stats vides
    for ($i=0; $i<20; $i++) {
        if ($classements[$i]['nb_match_joue'] == 0) {
            $classements[$i]['nom'] = $listeNoms;
        }
    }
        //        $classements = remplissage_classement_nom($listeNoms, $classements); 

        return response()->json($classements);

    }
    public function show(request $request)
    {
        $classementsNews=ListeMatch::with('equipe1','equipe2')
        ->where([['seasons_id',$request->seasons_id],['score','<>','-'], ['championnats_id', $request->championnats_id]])
        ->orderBy('date_match', 'desc')
        ->get();

        $listEquipes = Historique_equipes::where([['season_id',$request->seasons_id],['championnat_id', $request->championnats_id]])
        ->orderBy('equipe_id', 'asc')
        ->pluck('equipe_id');

        $listAdjusts = Adjust::where([['seasons_id',$request->seasons_id], ['championnats_id', 2]])
            ->orderBy('equipe_id', 'asc')
            ->get();

        $classements = calcul_classement($classementsNews, $listEquipes, $listAdjusts);

        // traitement pour le champ nom vide quand pas de stats
        $equipes = Equipe::where([['championnats_id', $request->championnats_id]])
            ->orderBy('nom', 'ASC')
            ->get();

        // $classements = remplissage_classement_nom($equipes, $classements);

        return response()->json($classements);
    }


}
