<?php

namespace App\Http\Controllers;

use App\Models\Adjust;
use App\Models\Equipe;
use App\Models\Classement;
use App\Models\ListeMatch;
use Illuminate\Http\Request;
use App\Models\Historique_equipes;

class ClassementController extends Controller
{
    public function index()
    {
        //$classements = Classement::with('Equipe')->orderBy('classement_en_cours', 'ASC')->get();
        //$classements = Classement::orderBy('classement_en_cours', 'ASC')->get();
        
        $cx_saison = 3;
        
        $classementsNews=ListeMatch::with('equipe1','equipe2')
            // ->where([['seasons_id',$cx_saison],['score','<>','-']])
            ->where([['seasons_id',$cx_saison],['score','<>','-'], ['championnats_id', 2]])
            ->orderBy('date_match', 'desc')
            ->get();

        $test = $classementsNews->isEmpty();

        $listEquipes = Historique_equipes::with(('equipe'))
            -> where([['season_id',$cx_saison],['championnat_id', 2]])
            ->orderBy('equipe_id', 'asc')
            //->pluck('equipe_id','equipe.nom');
            ->pluck('equipe_id');
            // ->get();

        $listAdjusts = Adjust::where([['seasons_id',$cx_saison], ['championnats_id', 2]])
        ->orderBy('equipe_id', 'asc')
        ->get();

        $classements = calcul_classement($classementsNews, $listEquipes, $listAdjusts);

        // dd($classements);        
        // Permet d'ajouter le nom de l'équipe quand stats vides
        
        /* $listeNoms = 'nom equipe';
        for ($i=0; $i<20; $i++) {
            if ($classements[$i]['nb_match_joue'] == 0) {
                $classements[$i]['nom'] = $listeNoms;
            }
        }
        */

        // dd($classements);
        return view('classements.index', compact('classements'));
    }
}
