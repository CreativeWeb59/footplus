<?php

namespace App\Http\Controllers\Api;

use App\Models\Equipe;
use App\Models\ListeMatch;
use App\Models\Championnat;
use Illuminate\Http\Request;
use App\Models\Historique_equipes;
use App\Http\Controllers\Controller;
use App\Http\Resources\ListeMatchResource;
use App\Http\Resources\ListeMatchResultatResource;

class ListeMatchController extends Controller
{
    public function index()
    {
        // recuperation du nombre d'equipe
        $championnat_id = 1;
        $seasons_id = 3;

        $nbEquipe = Championnat::where([['id', $championnat_id]])->pluck('nb_equipes')->first();
        $nbJournees = ($nbEquipe - 1) * 2;

        $cx_journee = 1;

        $calendriers = ListeMatchResource::collection(ListeMatch::with('equipe1', 'equipe2')->where('num_journee', $cx_journee)->where('seasons_id', $seasons_id)->orderBy('date_match', 'asc')->get());

        //return response()->json($nbJournees);
        return response()->json(['nbJournees' => $nbJournees, 'calendriers' => $calendriers]);
    }

    public function show(request $request)
    {
        // recuperation du nombre d'equipe
        $nbEquipe = Championnat::where([['id', $request->championnats_id]])->pluck('nb_equipes')->first();
        $nbJournees = ($nbEquipe - 1) * 2;
        $calendriers = ListeMatchResource::collection(ListeMatch::with('equipe1', 'equipe2')->where('championnats_id', $request->championnats_id)->where('num_journee', $request->cx_journee)->where('seasons_id', $request->seasons_id)->orderBy('date_match', 'asc')->get());

        //return response()->json($nbJournees);
        return response()->json(['nbJournees' => $nbJournees, 'calendriers' => $calendriers]);
    }

    public function update(request $request)
    {
        // maj d'un match dans la table ListeMatchs
        // $calendrier->update($request->only(['score','commentaire']));

        $updateData = ListeMatch::find($request->id);
        $updateData->score = $request->equipe1Score . '-' . $request->equipe2Score;
        $updateData->commentaire = $request->commentaire;
        $updateData->save();

        // $request->championnats_id = 2;
        // $request->cx_journee = 2;
        // $request->seasons_id = 2;

        // recuperation du nombre d'equipe
        $nbEquipe = Championnat::where([['id', $request->championnats_id]])->pluck('nb_equipes')->first();
        $nbJournees = ($nbEquipe - 1) * 2;
        $calendriers = ListeMatchResource::collection(ListeMatch::with('equipe1', 'equipe2')->where('championnats_id', $request->championnats_id)->where('num_journee', $request->cx_journee)->where('seasons_id', $request->seasons_id)->orderBy('date_match', 'asc')->get());

        //return response()->json($nbJournees);
        return response()->json(['nbJournees' => $nbJournees, 'calendriers' => $calendriers]);
        
    }

    public function updateScoreEquipe(request $request)
    {
        // maj d'un match dans la table ListeMatchs
        // $calendrier->update($request->only(['score','commentaire']));

        $updateData = ListeMatch::find($request->id);
        $updateData->score = $request->equipe1Score . '-' . $request->equipe2Score;
        $updateData->save();


        // recuperation du nombre d'equipe
        $nbEquipe = Championnat::where([['id', $request->championnats_id]])->pluck('nb_equipes')->first();
        $nbJournees = ($nbEquipe - 1) * 2;
        $calendriers = ListeMatchResource::collection(ListeMatch::with('equipe1', 'equipe2')->where('championnats_id', $request->championnats_id)->where('num_journee', $request->cx_journee)->where('seasons_id', $request->seasons_id)->orderBy('date_match', 'asc')->get());

        return response()->json(['nbJournees' => $nbJournees, 'calendriers' => $calendriers]);
        
    }

    public function updateCommentaire(request $request)
    {
        // maj d'un match dans la table ListeMatchs
        // $calendrier->update($request->only(['score','commentaire']));

        $updateData = ListeMatch::find($request->id);
        $updateData->commentaire = $request->commentaire;
        $updateData->save();


        // recuperation du nombre d'equipe
        $nbEquipe = Championnat::where([['id', $request->championnats_id]])->pluck('nb_equipes')->first();
        $nbJournees = ($nbEquipe - 1) * 2;
        $calendriers = ListeMatchResource::collection(ListeMatch::with('equipe1', 'equipe2')->where('championnats_id', $request->championnats_id)->where('num_journee', $request->cx_journee)->where('seasons_id', $request->seasons_id)->orderBy('date_match', 'asc')->get());

        return response()->json(['nbJournees' => $nbJournees, 'calendriers' => $calendriers]);
        
    }

    // Affiche la liste des matchs de chaque equipe
    public function list(request $request)
    {
        // 1 ==> tous les résultats de l'équipe
        // 2 ==> résultats à domicile
        // 3 ==> résultats à l'exterieur
        // 4 ==> prochains matchs de l'équipe
        $cx_stats = $request->cxResultats_id;
        
        // recupere l'id de l'equipe
        // $equipesId = Historique_equipes::where('id', $request->equipesId)->pluck('equipe_id');
        $equipesId = $request->equipesId;

        switch($cx_stats){
            case(1):
                // $listeMatchs=ListeMatch::with('equipe1','equipe2')->where([['equipes1_id',$equipesId],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orWhere([['equipes2_id',$equipesId],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orderBy('date_match', 'desc')->get();
                $listeMatchs=ListeMatchResultatResource::collection(ListeMatch::with('equipe1','equipe2')->where([['equipes1_id',$equipesId],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orWhere([['equipes2_id',$equipesId],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orderBy('date_match', 'desc')->get());
                break;
            case(2):
                // $listeMatchs=ListeMatch::with('equipe1','equipe2')->where([['equipes1_id',$equipesId],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orderBy('date_match', 'desc')->get();
                $listeMatchs=ListeMatchResultatResource::collection(ListeMatch::with('equipe1','equipe2')->where([['equipes1_id',$equipesId],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orderBy('date_match', 'desc')->get());
                break;
            case(3):
                // $listeMatchs=ListeMatch::with('equipe1','equipe2')->where([['equipes2_id',$equipesId],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orderBy('date_match', 'desc')->get();
                $listeMatchs=ListeMatchResultatResource::collection(ListeMatch::with('equipe1','equipe2')->where([['equipes2_id',$equipesId],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orderBy('date_match', 'desc')->get());
                break;
            case(4):
                // $listeMatchs=ListeMatch::with('equipe1','equipe2')->where([['equipes1_id',$equipesId],['score','-'], ['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orwhere([['equipes2_id',$equipesId],['score','-'],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orderBy('date_match', 'desc')->get();
                $listeMatchs=ListeMatchResultatResource::collection(ListeMatch::with('equipe1','equipe2')->where([['equipes1_id',$equipesId],['score','-'], ['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orwhere([['equipes2_id',$equipesId],['score','-'],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orderBy('date_match', 'desc')->get());
                break;
            default:
            $listeMatchs=ListeMatchResultatResource::collection(ListeMatch::with('equipe1','equipe2')->where([['equipes1_id',$equipesId],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orWhere([['equipes2_id',$equipesId],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orderBy('date_match', 'desc')->get());
        }

        return response()->json($listeMatchs);
    }
}
