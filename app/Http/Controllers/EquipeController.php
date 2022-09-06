<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\ListeMatch;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    public function index()
    {
        $equipes = Equipe::orderBy('nom', 'ASC')->get();
        
        $cx_saison = 2;
        $cx_championnat = 1;

        $equipes=Equipe::with('seasons')
            ->where([['equipe_id',10]])
//            ->orderBy('date_match', 'desc')
            ->get();
        dd($equipes);

        return view('equipes.index', compact('equipes'));
    }
}
