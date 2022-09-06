<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historique_equipes;
use Illuminate\Support\Facades\DB;

class HistoriqueEquipesController extends Controller
{
    public function index()
    {
        // valeurs par defaut a retirer d'une table options
        $cx_saison = 3;
        $cx_championnat = 1;

        $equipes = Historique_equipes::with(['equipe'=> function ($q) {
            $q->orderBy('nom','asc');
            }])    
            ->where('season_id',3)
            ->where('championnat_id',1)
            ->get();

            $cx_equipe1 = 18;

            $stats['cptDomicile1'] = DB::table('liste_Matches')
                 ->where([['equipes1_id',$cx_equipe1],['score','<>','-']])
                 ->orderBy('date_match', 'desc')
                 ->count();

        dd($stats);
        return view('equipes.index', compact('equipes'));
        
    }
}
