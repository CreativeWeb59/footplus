<?php

namespace App\Http\Controllers;

use App\Models\Championnat;
use App\Models\Equipe;
use App\Models\Season;
use App\Models\Classement;
use App\Models\ListeMatch;
use Illuminate\Http\Request;
use App\Models\Historique_equipes;

class JourneesController extends Controller
{
    // recup donnees table classement
    public function index()
    {
        // Liste des saisons
        $lSaisons = Season::orderBy('id', 'DESC')->get();
        
        //récupère l'id de la dernière saison inscrite
        $sSelected = Season::orderBy('id', 'DESC')->pluck('id')->first();

        // Liste des championnats
        $lChampionnats = Championnat::orderBy('id', 'ASC')->get();

        //récupère l'id du dernier championnat inscrit
        $cSelected = Championnat::orderBy('id', 'ASC')->pluck('id')->first();

        // variables necessaires qui seront en paramètre

        // $renvoi['championnat']="Ligue 1 France";
        $renvoi['nbJournees']=38;
        $renvoi['num_journee']=1;

        // $equipes = Equipe::orderBy('nom', 'ASC')->get();
        $equipes = Historique_equipes::with(['equipe'])    
            ->where('season_id',$sSelected)
            ->where('championnat_id',$cSelected)
            ->get();

        $equipes = $equipes->sortBy('equipe.nom');

        return view('journees.index', compact('equipes','lSaisons','lChampionnats','renvoi', 'sSelected','cSelected'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Creation des matchs
        if ($request->buts_equipe1 > -1) {
            $request->request->add(['score' => $request -> buts_equipe1 . "-".$request -> buts_equipe2]); // ajoute le score
        } else {
            // traitement du score
            $request->request->add(['score' => '-']); // ajoute le score
        }

        // verification si le match n'a pas encore été joué

        // Traitement pour le classement
        // Uniquement si score renseigné
        // Recuperation des données de la table Classement

        // Enregistrement dans la table match => creation

        $match = ListeMatch::create($this->validator());
        // $match = ListeMatch::create($request->all());

        // Fin traitement du score
  
        session()->flash('message', 'Match ajouté avec succès');

        //session()->flash('message', $match->title.' ajouté avec succès');

        // Liste des saisons
        $lSaisons = Season::orderBy('id', 'DESC')->get();
        
        // Liste des championnats
        $lChampionnats = Championnat::orderBy('id', 'ASC')->get();
        
        // $renvoi['championnat']="Ligue 1 France";
        $renvoi['nbJournees']=38;

        // recuperation des données à renvoyer au formulaire avec le champ : identique
        if ($request->identique == 1) {

            $sSelected = $request->seasons_id;
            $cSelected = $request->championnats_id;

            // Saison + championnat
            // num_journee
            // date_match + heure_match
            $saison = "2021-2021";
            $championnat = "Ligue 1 France";
           
            $renvoi['num_journee']=$request->num_journee;
            $renvoi['date_match']=$request->date_match;
            $renvoi['heure_match']=$request->heure_match;

        } else {
            //récupère l'id de la dernière saison inscrite
            $sSelected = Season::orderBy('id', 'DESC')->pluck('id')->first();

            // variables necessaires qui seront en paramètre
            $renvoi['num_journee']=1;
            }

            // $equipes = Equipe::orderBy('nom', 'ASC')->get();
            $equipes = Historique_equipes::with(['equipe'])    
            ->where('season_id',$request->seasons_id)
            ->where('championnat_id',$cSelected)
            ->get();
            
            $equipes = $equipes->sortBy('equipe.nom');

            return view('journees.index', compact('equipes','renvoi','lSaisons','sSelected','lChampionnats','cSelected'));

    }

    public function validator()
    {
        return request()->validate([
            'seasons_id'=>'required|Numeric',
            'championnats_id'=>'required|Numeric',
            'equipes1_id'=>'required|Numeric',
            'equipes2_id'=>'required|Numeric',
            'num_journee'=>'required|Numeric',
            'commentaire'=>'max:255',
            'score'=>'max:20',
            'date_match'=>'required|Date',
            'heure_match'=>'required|min:3|max:10'
        ]);
    }
}
