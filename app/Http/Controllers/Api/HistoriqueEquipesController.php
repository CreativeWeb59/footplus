<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Historique_equipes;
use App\Http\Controllers\Controller;

class HistoriqueEquipesController extends Controller
{
    public function index()
    {
        /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
        // valeurs par defaut a retirer d'une table options
        $cx_saison = 3;
        $cx_championnat = 1;

        $equipes = Historique_equipes::with(['equipe'])    
            ->where('season_id',$cx_saison)
            ->where('championnat_id',$cx_championnat)
            ->get();
            
        $equipes = $equipes->sortBy('equipe.nom');
        
        return response()->json($equipes);
    }

    public function show(request $request)
    {
        $equipes = Historique_equipes::with(['equipe'])    
            ->where('season_id',$request->seasons_id)
            ->where('championnat_id',$request->championnats_id)
            ->get();
        $equipes = $equipes->sortBy('equipe.nom');
        
        return response()->json($equipes);
    }
}