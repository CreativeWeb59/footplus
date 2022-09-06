<?php

namespace App\Http\Controllers;
use App\Models\Equipe;
use App\Models\ListeMatch;
use App\Models\Classement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultatController extends Controller
{
    public function index()
    {
        // recup des ListeMatch de la journée en cours
        // table ListeMatch

        $cx_equipe1 = 0;
        $cx_equipe2 = 0;

        $cx_stats1 = 1;
        $cx_stats2 = 1;

        $cx_saison = 2;

        //$ListeMatch=ListeMatch::where('num_journee',$jEnCours)->orderBy('date_match', 'ASC')->get();

        $ListeMatch1=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe1)->orWhere('equipes2_id',$cx_equipe1)->orderBy('date_match', 'desc')->get();
        $ListeMatch2=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe2)->orWhere('equipes2_id',$cx_equipe2)->orderBy('date_match', 'desc')->get();


        $lEquipes=Equipe::orderBy('nom', 'ASC')->get();
        $nEquipe1=Equipe::orderBy('nom', 'ASC')->where('id',$cx_equipe1)->first();


        // Calcul du classement à partir de la table match
        // Selection dans la table match de la saison + championnat en cours
        // stockage dans un tableau

        $classementsNews=ListeMatch::with('equipe1','equipe2')
            ->where([['saisons_id',$cx_saison],['score','<>','-']])
            ->orderBy('date_match', 'desc')
            ->get();

        $classements = calcul_classement($classementsNews);        

        return view('auth.user.resultat.index', compact('ListeMatch1','ListeMatch2','classements','lEquipes','nEquipe1','cx_equipe1','cx_equipe2','cx_stats1','cx_stats2'));
    }

    public function showEquipe(request $request)
    {
        // recup des ListeMatch de la journée en cours
        // table ListeMatch

        $cx_equipe1 = $request->cx_equipe1;
        $cx_equipe2 = $request->cx_equipe2;

        // 1 ==> tous les résultats de l'équipe
        // 2 ==> résultats à domicile
        // 3 ==> résultats à l'exterieur
        // 4 ==> prochains ListeMatch de l'équipe
        $cx_stats1 = $request->cx_stats1;
        $cx_stats2 = $request->cx_stats2;

        switch($cx_stats1){
            case(1):
                $ListeMatch1=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe1)->orWhere('equipes2_id',$cx_equipe1)->orderBy('date_match', 'desc')->get();
                break;
            case(2):
                $ListeMatch1=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe1)->orderBy('date_match', 'desc')->get();
                break;
            case(3):
                $ListeMatch1=ListeMatch::with('equipe1','equipe2')->where('equipes2_id',$cx_equipe1)->orderBy('date_match', 'desc')->get();
                break;
            case(4):
                $ListeMatch1=ListeMatch::with('equipe1','equipe2')->where([['equipes1_id',$cx_equipe1],['score','-']])->orwhere([['equipes2_id',$cx_equipe1],['score','-']])->orderBy('date_match', 'desc')->get();
                break;
            default:
                $ListeMatch1=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe1)->orderBy('date_match', 'desc')->get();
        }

        switch($cx_stats2){
            case(1):
                $ListeMatch2=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe2)->orWhere('equipes2_id',$cx_equipe2)->orderBy('date_match', 'desc')->get();
                break;
            case(2):
                $ListeMatch2=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe2)->orderBy('date_match', 'desc')->get();
                break;
            case(3):
                $ListeMatch2=ListeMatch::with('equipe1','equipe2')->where('equipes2_id',$cx_equipe2)->orderBy('date_match', 'desc')->get();
                break;
            case(4):
                $ListeMatch2=ListeMatch::with('equipe1','equipe2')->where([['equipes1_id',$cx_equipe2],['score','-']])->orwhere([['equipes2_id',$cx_equipe2],['score','-']])->orderBy('date_match', 'desc')->get();
                break;
            default:
                $ListeMatch2=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe2)->orderBy('date_match', 'desc')->get();
        }

        $lEquipes=Equipe::orderBy('nom', 'ASC')->get();
        $nEquipe1=Equipe::orderBy('nom', 'ASC')->where('id',$cx_equipe1)->first();

        // Parties statistiques par équipe :
        // Partie 1
        // ListeMatch à domicile
        $stats1['cptDomicile1'] = DB::table('ListeMatch')
             ->where([['equipes1_id',$cx_equipe1],['score','<>','-']])
             ->orderBy('date_match', 'desc')
             ->count();
             
        $ListeMatchDomicile1s=ListeMatch::where([['equipes1_id',$cx_equipe1],['score','<>','-']])->orderBy('date_match', 'desc')->get();
        $stats1['nbVictoireDomicile'] = 0;
        $stats1['nbDefaiteDomicile'] = 0;
        $stats1['nbNullDomicile'] = 0;

        foreach($ListeMatchDomicile1s as $ListeMatchDomicile1){
            if (calcul_resultat($ListeMatchDomicile1->score,true)=='victoire'){
                $stats1['nbVictoireDomicile']++;
            }
            if (calcul_resultat($ListeMatchDomicile1->score,true)=='defaite'){
                $stats1['nbDefaiteDomicile']++;
            }
            if (calcul_resultat($ListeMatchDomicile1->score,true)=='null'){
                $stats1['nbNullDomicile']++;
            }
        }

        // Formule pourcentage : [Valeur 1] x 100 / [Valeur2] = [Résultat en %]
        if ($stats1['cptDomicile1'] != 0) {
            $stats1['PVictoireDomicile'] = number_format($stats1['nbVictoireDomicile'] * 100 / $stats1['cptDomicile1'],2);
            $stats1['PDefaiteDomicile'] = number_format($stats1['nbDefaiteDomicile'] * 100 / $stats1['cptDomicile1'],2);
            $stats1['PNullDomicile'] = number_format($stats1['nbNullDomicile'] * 100 / $stats1['cptDomicile1'],2);
        } else {
            $stats1['PVictoireDomicile'] = 0;
            $stats1['PDefaiteDomicile'] = 0;
            $stats1['PNullDomicile'] = 0;
        }
        
        // ListeMatch à l'exterieur
        $stats1['cptExterieur1'] = DB::table('ListeMatch')
             ->where([['equipes2_id',$cx_equipe1],['score','<>','-']])
             ->orderBy('date_match', 'desc')
             ->count();
             
        $ListeMatchExterieur1s=ListeMatch::where([['equipes2_id',$cx_equipe1],['score','<>','-']])->orderBy('date_match', 'desc')->get();
        $stats1['nbVictoireExterieur'] = 0;
        $stats1['nbDefaiteExterieur'] = 0;
        $stats1['nbNullExterieur'] = 0;

        foreach($ListeMatchExterieur1s as $ListeMatchExterieur1){
            if (calcul_resultat($ListeMatchExterieur1->score,false)=='victoire'){
                $stats1['nbVictoireExterieur']++;
            }
            if (calcul_resultat($ListeMatchExterieur1->score,false)=='defaite'){
                $stats1['nbDefaiteExterieur']++;
            }
            if (calcul_resultat($ListeMatchExterieur1->score,false)=='null'){
                $stats1['nbNullExterieur']++;
            }
        }

        // Formule pourcentage : [Valeur 1] x 100 / [Valeur2] = [Résultat en %]
        if ($stats1['cptDomicile1'] != 0) {
            $stats1['PVictoireExterieur'] = number_format($stats1['nbVictoireExterieur'] * 100 / $stats1['cptExterieur1'],2);
            $stats1['PDefaiteExterieur'] = number_format($stats1['nbDefaiteExterieur'] * 100 / $stats1['cptExterieur1'],2);
            $stats1['PNullExterieur'] = number_format($stats1['nbNullExterieur'] * 100 / $stats1['cptExterieur1'],2);
        }else{
            $stats1['PVictoireExterieur'] = 0;
            $stats1['PDefaiteExterieur'] = 0;
            $stats1['PNullExterieur'] = 0;
        }


        // Partie 2
        // ListeMatch à domicile
        $stats2['cptDomicile2'] = DB::table('ListeMatch')
             ->where([['equipes1_id',$cx_equipe2],['score','<>','-']])
             ->orderBy('date_match', 'desc')
             ->count();

        $ListeMatchDomicile2s=ListeMatch::where([['equipes1_id',$cx_equipe2],['score','<>','-']])->orderBy('date_match', 'desc')->get();
        $stats2['nbVictoireDomicile'] = 0;
        $stats2['nbDefaiteDomicile'] = 0;
        $stats2['nbNullDomicile'] = 0;

        foreach($ListeMatchDomicile2s as $ListeMatchDomicile2){
            if (calcul_resultat($ListeMatchDomicile2->score,true)=='victoire'){
                $stats2['nbVictoireDomicile']++;
            }
            if (calcul_resultat($ListeMatchDomicile2->score,true)=='defaite'){
                $stats2['nbDefaiteDomicile']++;
            }
            if (calcul_resultat($ListeMatchDomicile2->score,true)=='null'){
                $stats2['nbNullDomicile']++;
            }
        }

        // Formule pourcentage : [Valeur 1] x 100 / [Valeur2] = [Résultat en %]
        if ($stats2['cptDomicile2'] != 0) {
            $stats2['PVictoireDomicile'] = number_format($stats2['nbVictoireDomicile'] * 100 / $stats2['cptDomicile2'],2);
            $stats2['PDefaiteDomicile'] = number_format($stats2['nbDefaiteDomicile'] * 100 / $stats2['cptDomicile2'],2);
            $stats2['PNullDomicile'] = number_format($stats2['nbNullDomicile'] * 100 / $stats2['cptDomicile2'],2);
        }else{
            $stats2['PVictoireDomicile'] = 0;
            $stats2['PDefaiteDomicile'] = 0;
            $stats2['PNullDomicile'] = 0;
        }
        
        // ListeMatch à l'exterieur
        $stats2['cptExterieur2'] = DB::table('ListeMatch')
             ->where([['equipes2_id',$cx_equipe2],['score','<>','-']])
             ->orderBy('date_match', 'desc')
             ->count();
             
        $ListeMatchExterieur2s=ListeMatch::where([['equipes2_id',$cx_equipe2],['score','<>','-']])->orderBy('date_match', 'desc')->get();
        $stats2['nbVictoireExterieur'] = 0;
        $stats2['nbDefaiteExterieur'] = 0;
        $stats2['nbNullExterieur'] = 0;

        foreach($ListeMatchExterieur2s as $ListeMatchExterieur2){
            if (calcul_resultat($ListeMatchExterieur2->score,false)=='victoire'){
                $stats2['nbVictoireExterieur']++;
            }
            if (calcul_resultat($ListeMatchExterieur2->score,false)=='defaite'){
                $stats2['nbDefaiteExterieur']++;
            }
            if (calcul_resultat($ListeMatchExterieur2->score,false)=='null'){
                $stats2['nbNullExterieur']++;
            }
        }

        // Formule pourcentage : [Valeur 1] x 100 / [Valeur2] = [Résultat en %]
        if ($stats2['cptExterieur2'] != 0) {
            $stats2['PVictoireExterieur'] = number_format($stats2['nbVictoireExterieur'] * 100 / $stats2['cptExterieur2'],2);
            $stats2['PDefaiteExterieur'] = number_format($stats2['nbDefaiteExterieur'] * 100 / $stats2['cptExterieur2'],2);
            $stats2['PNullExterieur'] = number_format($stats2['nbNullExterieur'] * 100 / $stats2['cptExterieur2'],2);
        }else{
            $stats2['PVictoireExterieur'] = 0;
            $stats2['PDefaiteExterieur'] = 0;
            $stats2['PNullExterieur'] = 0;
        }

        // calcul du classement
        $cx_saison = 2;
        $classementsNews=ListeMatch::with('equipe1','equipe2')
        ->where([['saisons_id',$cx_saison],['score','<>','-']])
        ->orderBy('date_match', 'desc')
        ->get();

        $classements = calcul_classement($classementsNews); 

        return view('auth.user.resultat.index', compact('ListeMatch1','ListeMatch2','classements','lEquipes','nEquipe1','cx_equipe1','cx_equipe2','cx_stats1','cx_stats2','stats1','stats2'));
    }
    
    public function showEquipe2(request $request)
    {
        // recup des ListeMatch de la journée en cours
        // table ListeMatch


        //dd('select 2');
        $cx_equipe2 = $request->cx_equipe2;
        $cx_equipe1 = $request->cx_equipe1;
        // 1 ==> tous les résultats de l'équipe
        // 2 ==> résultats à domicile
        // 3 ==> résultats à l'exterieur
        // 4 ==> prochains ListeMatch de l'équipe
        $cx_stats2 = $request->cx_stats2;
        $cx_stats1 = $request->cx_stats1;

        switch($cx_stats2){
            case(1):
                $ListeMatch=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe2)->orWhere('equipes2_id',$cx_equipe2)->orderBy('date_match', 'desc')->get();
                break;
            case(2):
                $ListeMatch=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe2)->orderBy('date_match', 'desc')->get();
                break;
            case(3):
                $ListeMatch=ListeMatch::with('equipe1','equipe2')->where('equipes2_id',$cx_equipe2)->orderBy('date_match', 'desc')->get();
                break;
            case(4):
                $ListeMatch=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe2)->orderBy('date_match', 'desc')->get();
                break;
            default:
                $ListeMatch=ListeMatch::with('equipe1','equipe2')->where('equipes1_id',$cx_equipe2)->orderBy('date_match', 'desc')->get();
            }

        $lEquipes=Equipe::orderBy('nom', 'ASC')->get();



        $classements=Classement::with('Equipe')->orderBy('classement_en_cours', 'ASC')->get();
        
        return view('auth.user.resultat.index', compact('ListeMatch','classements','lEquipes','cx_equipe1','cx_equipe2','cx_stats2','cx_stats1','nbListeMatch1'));
    }

}
