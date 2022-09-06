<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\ListeMatch;
use Illuminate\Http\Request;

class ParisController extends Controller
{
    public function index()
    {
        $equipes = Equipe::where([['championnats_id', 2]])
            ->orderBy('nom', 'ASC')
            ->get();

        $seasons_id = 3;
        $championnats_id = 1;

        $classementsNews=ListeMatch::with('equipe1','equipe2')
        ->where([['seasons_id',$seasons_id],['score','<>','-'], ['championnats_id', $championnats_id]])
        ->orderBy('date_match', 'desc')
        ->get();

    $classements = calcul_classement($classementsNews);

        // Permet d'ajouter le nom de l'équipe quand stats vides
        /*
        for ($i=0; $i<20; $i++) {
            if ($classements[$i]['nb_match_joue'] == 0) {
                $classements[$i]['nom'] = 'test2';
            }
        }
        */
               
        $classements = remplissage_classement_nom($equipes, $classements);
        return view('paris.index', compact('equipes', 'classements'));
    }
}
