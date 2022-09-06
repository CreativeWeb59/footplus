<?php

namespace App\Http\Controllers;

use App\Models\ListeMatch;
use Illuminate\Http\Request;
use App\Models\Historique_equipes;

class ListeMatchController extends Controller
{
    public function index()
    {
        // Calcul du classement à partir de la table match
        // Selection dans la table match de la saison + championnat en cours
        // stockage dans un tableau
        $cx_saison = 2;
        
        // calcul cx_journee à l'ouverture de la page
        // recherche dans la base les matchs : score = "-"
        // tri par date_match croissant
        // recupere premier champ journee championnat

        // A modifier
        $cx_journee = 1;
        // $cx_journee=ListeMatch::where('score','-')->where('seasons_id', 2)->orderBy('date_match', 'asc')->first(['num_journee'])->num_journee;

        $testDate_match=ListeMatch::where('score','-')->where('seasons_id', 2)->orderBy('date_match', 'asc')->first(['date_match']);

        // Test date du match
        if (is_null($testDate_match)) {
            $date_match = '04/04/2022';
        }else{
            $date_match=ListeMatch::where('score','-')->where('seasons_id', 2)->orderBy('date_match', 'asc')->first(['date_match'])->date_match;
        }

        $classementsNews=ListeMatch::with('equipe1','equipe2')
            ->where([['seasons_id',$cx_saison],['score','<>','-']])
            ->orderBy('date_match', 'desc')
            ->get();

        $listEquipes = Historique_equipes::where([['season_id',$cx_saison],['championnat_id', 1]])
            ->orderBy('equipe_id', 'asc')
            ->pluck('equipe_id');

        $calendriers=ListeMatch::with('equipe1','equipe2')->where('num_journee',$cx_journee)->where('seasons_id', 2)->orderBy('date_match', 'asc')->get();
        
        return view('listeMatch.index', compact('cx_journee','calendriers','date_match'));
    }

    public function listeMatchs(request $request)
    {
        
    }
}
