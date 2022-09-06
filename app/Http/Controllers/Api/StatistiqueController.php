<?php

namespace App\Http\Controllers\Api;

use App\Models\ListeMatch;
use App\Models\Historique_equipes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Les stats
        // Parties statistiques par équipe :
        // Partie 1
        // Matchs à domicile

        $cx_equipe1 = 1;
        $cx_saison = 2;
        $cx_championnat = 1;

        $stats['cptDomicile1'] = DB::table('liste_Matches')
             ->where([['equipes1_id', $cx_equipe1],['score','<>','-'],['seasons_id', $cx_saison],['championnats_id', $cx_championnat]])
             ->orderBy('date_match', 'desc')
             ->count();
             
        $matchsDomicile1s=ListeMatch::where([['equipes1_id',$cx_equipe1],['score','<>','-'],['seasons_id', $cx_saison],['championnats_id', $cx_championnat]])->orderBy('date_match', 'desc')->get();
        $stats['nbVictoireDomicile'] = 0;
        $stats['nbDefaiteDomicile'] = 0;
        $stats['nbNullDomicile'] = 0;

        
        foreach($matchsDomicile1s as $matchsDomicile1){
            if (calcul_resultat($matchsDomicile1->score,true)=='victoire'){
                $stats['nbVictoireDomicile']++;
            }
            if (calcul_resultat($matchsDomicile1->score,true)=='defaite'){
                $stats['nbDefaiteDomicile']++;
            }
            if (calcul_resultat($matchsDomicile1->score,true)=='null'){
                $stats['nbNullDomicile']++;
            }
        }
        
        // Formule pourcentage : [Valeur 1] x 100 / [Valeur2] = [Résultat en %]
        
        if ($stats['cptDomicile1'] != 0) {
            $stats['PVictoireDomicile'] = number_format($stats['nbVictoireDomicile'] * 100 / $stats['cptDomicile1'],2);
            $stats['PDefaiteDomicile'] = number_format($stats['nbDefaiteDomicile'] * 100 / $stats['cptDomicile1'],2);
            $stats['PNullDomicile'] = number_format($stats['nbNullDomicile'] * 100 / $stats['cptDomicile1'],2);
        } else {
            $stats['PVictoireDomicile'] = 0;
            $stats['PDefaiteDomicile'] = 0;
            $stats['PNullDomicile'] = 0;
        }
        

        // Matchs à l'exterieur
        
        $stats['cptExterieur1'] = DB::table('liste_Matches')
             ->where([['equipes2_id',$cx_equipe1],['score','<>','-'],['seasons_id', $cx_saison],['championnats_id', $cx_championnat]])
             ->orderBy('date_match', 'desc')
             ->count();
             
        $matchsExterieur1s=ListeMatch::where([['equipes2_id',$cx_equipe1],['score','<>','-'],['seasons_id', $cx_saison],['championnats_id', $cx_championnat]])->orderBy('date_match', 'desc')->get();
        $stats['nbVictoireExterieur'] = 0;
        $stats['nbDefaiteExterieur'] = 0;
        $stats['nbNullExterieur'] = 0;

        foreach($matchsExterieur1s as $matchsExterieur1){
            if (calcul_resultat($matchsExterieur1->score,false)=='victoire'){
                $stats['nbVictoireExterieur']++;
            }
            if (calcul_resultat($matchsExterieur1->score,false)=='defaite'){
                $stats['nbDefaiteExterieur']++;
            }
            if (calcul_resultat($matchsExterieur1->score,false)=='null'){
                $stats['nbNullExterieur']++;
            }
        }

        // Formule pourcentage : [Valeur 1] x 100 / [Valeur2] = [Résultat en %]
        if ($stats['cptDomicile1'] != 0) {
            $stats['PVictoireExterieur'] = number_format($stats['nbVictoireExterieur'] * 100 / $stats['cptExterieur1'],2);
            $stats['PDefaiteExterieur'] = number_format($stats['nbDefaiteExterieur'] * 100 / $stats['cptExterieur1'],2);
            $stats['PNullExterieur'] = number_format($stats['nbNullExterieur'] * 100 / $stats['cptExterieur1'],2);
        }else{
            $stats['PVictoireExterieur'] = 0;
            $stats['PDefaiteExterieur'] = 0;
            $stats['PNullExterieur'] = 0;
        }
        
        // Les stats fin

        return response()->json($stats);
    }

    public function show(request $request)
    {
        // Les stats
        // Parties statistiques par équipe :
        // Partie 1
        // Matchs à domicile

        // recupere l'id de l'equipe

        // $cx_equipe1 = Historique_equipes::where('id', $request->equipesId)->pluck('equipe_id');
        $cx_equipe1 = $request->equipesId;

        $stats['cptDomicile1'] = DB::table('liste_Matches')
             ->where([['equipes1_id', $cx_equipe1],['score','<>','-'],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])
             ->orderBy('date_match', 'desc')
             ->count();
             
        $matchsDomicile1s=ListeMatch::where([['equipes1_id',$cx_equipe1],['score','<>','-'],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orderBy('date_match', 'desc')->get();
        $stats['nbVictoireDomicile'] = 0;
        $stats['nbDefaiteDomicile'] = 0;
        $stats['nbNullDomicile'] = 0;

        
        foreach($matchsDomicile1s as $matchsDomicile1){
            if (calcul_resultat($matchsDomicile1->score,true)=='victoire'){
                $stats['nbVictoireDomicile']++;
            }
            if (calcul_resultat($matchsDomicile1->score,true)=='defaite'){
                $stats['nbDefaiteDomicile']++;
            }
            if (calcul_resultat($matchsDomicile1->score,true)=='null'){
                $stats['nbNullDomicile']++;
            }
        }
        
        // Formule pourcentage : [Valeur 1] x 100 / [Valeur2] = [Résultat en %]
        
        if ($stats['cptDomicile1'] != 0) {
            $stats['PVictoireDomicile'] = number_format($stats['nbVictoireDomicile'] * 100 / $stats['cptDomicile1'],2);
            $stats['PDefaiteDomicile'] = number_format($stats['nbDefaiteDomicile'] * 100 / $stats['cptDomicile1'],2);
            $stats['PNullDomicile'] = number_format($stats['nbNullDomicile'] * 100 / $stats['cptDomicile1'],2);
        } else {
            $stats['PVictoireDomicile'] = 0;
            $stats['PDefaiteDomicile'] = 0;
            $stats['PNullDomicile'] = 0;
        }
        

        // Matchs à l'exterieur
        
        $stats['cptExterieur1'] = DB::table('liste_Matches')
             ->where([['equipes2_id',$cx_equipe1],['score','<>','-'],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])
             ->orderBy('date_match', 'desc')
             ->count();
             
        $matchsExterieur1s=ListeMatch::where([['equipes2_id',$cx_equipe1],['score','<>','-'],['seasons_id', $request->seasons_id],['championnats_id', $request->championnats_id]])->orderBy('date_match', 'desc')->get();
        $stats['nbVictoireExterieur'] = 0;
        $stats['nbDefaiteExterieur'] = 0;
        $stats['nbNullExterieur'] = 0;

        foreach($matchsExterieur1s as $matchsExterieur1){
            if (calcul_resultat($matchsExterieur1->score,false)=='victoire'){
                $stats['nbVictoireExterieur']++;
            }
            if (calcul_resultat($matchsExterieur1->score,false)=='defaite'){
                $stats['nbDefaiteExterieur']++;
            }
            if (calcul_resultat($matchsExterieur1->score,false)=='null'){
                $stats['nbNullExterieur']++;
            }
        }

        // Formule pourcentage : [Valeur 1] x 100 / [Valeur2] = [Résultat en %]
        if ($stats['cptDomicile1'] != 0) {
            $stats['PVictoireExterieur'] = number_format($stats['nbVictoireExterieur'] * 100 / $stats['cptExterieur1'],2);
            $stats['PDefaiteExterieur'] = number_format($stats['nbDefaiteExterieur'] * 100 / $stats['cptExterieur1'],2);
            $stats['PNullExterieur'] = number_format($stats['nbNullExterieur'] * 100 / $stats['cptExterieur1'],2);
        }else{
            $stats['PVictoireExterieur'] = 0;
            $stats['PDefaiteExterieur'] = 0;
            $stats['PNullExterieur'] = 0;
        }
        
        // Les stats fin

        return response()->json($stats);
    }
}
