<?php

if (!function_exists('calcul_resultat')) {
//    function calcul_resultat(?string $le_score = null ) :string {
    // fonction qui donne le resultat = null, gagne, perdu suivant un score complet du style : 2-1
    // recupere tout ce qui est a gauche du caractère "-" et le transforme en integer
    // recupere tout ce qui est a droite du caractère "-" et le transforme en integer
    // $maison oui=match à domicile
    // $maison non=match à l'exterieur
    function calcul_resultat($le_score, $maison) {
    $pos = strpos($le_score, "-"); // position du caractere -
    $scr1 = (int)substr($le_score,0,$pos);
    $pos++;
    $scr2 = (int)substr($le_score,$pos);
    $resultat="victoire";


    if ($le_score=='-') {
        $resultat = "bientot";
        return $resultat;
    }

    if ($maison==true) {
        if ($scr1>$scr2) {
            $resultat = "victoire";
            }else {
            $resultat = "defaite";
        }
    }
    if ($maison==false) {
        if ($scr1>$scr2) {
            $resultat = "defaite";
        }else {
            $resultat = "victoire";
        }
    }
    if ($scr1==$scr2) {
        $resultat = "null";
    }
    return $resultat;
        
    }
}

if (!function_exists('calcul_score')) {

    // Renvoi uniquement le score suivant le shema : 3-4
    // true pour le score de gauche
    // false pour le score de droite

    function calcul_score($le_score,$gauche) {
        $pos = strpos($le_score, "-"); // position du caractere -
        $scr1 = (int)substr($le_score,0,$pos);
        $pos++;
        $scr2 = (int)substr($le_score,$pos);

        if($gauche==true) {
            return $scr1;
        }else{
            return $scr2;
        }
    }
}

if (!function_exists('calcul_classement')) {

    function calcul_classement($classementsNews, $listEquipes, $listAdjusts) {

    // Tableau Classement
    foreach($listEquipes as $key => $listEquipe){
        $classements[$key]['classement_en_cours']= 0;
        $classements[$key]['points']= 0;
        $classements[$key]['nb_match_joue']= 0;
        $classements[$key]['nb_match_gagne']= 0;
        $classements[$key]['nb_match_null']= 0;
        $classements[$key]['nb_match_perdu']= 0;
        $classements[$key]['but_marque']= 0;
        $classements[$key]['but_encaisse']= 0;
        $classements[$key]['difference_but']= 0;

        // integration des ajustements si malus debut de saison
        // $testAdjust = $listAdjust->isEmpty();

        
        foreach($listAdjusts as $listAdjust){
            if($listAdjust->equipe_id == $listEquipe) {
                $classements[$key]['points']= $listAdjust->valeur;
            }
        }


    foreach($classementsNews as $classementsNew){
        if ($classementsNew->equipes1_id == $listEquipe){
            $classements[$key]['nb_match_joue']++;
            $classements[$key]['but_marque'] += calcul_score($classementsNew->score,true);
            $classements[$key]['but_encaisse'] += calcul_score($classementsNew->score,false);
            if ((calcul_resultat($classementsNew->score,true) == 'victoire')){
                $classements[$key]['nb_match_gagne'] ++;
                $classements[$key]['points'] = $classements[$key]['points'] + 3;
            }
            if ((calcul_resultat($classementsNew->score,true) == 'defaite')){
                $classements[$key]['nb_match_perdu'] ++;
            }
            if ((calcul_resultat($classementsNew->score,true) == 'null')){
                $classements[$key]['nb_match_null'] ++;
                $classements[$key]['points'] = $classements[$key]['points'] + 1;
            }
            $classements[$key]['nom']= $classementsNew->equipe1->nom;
        }
        if ($classementsNew->equipes2_id == $listEquipe){
            $classements[$key]['nb_match_joue']++;
            $classements[$key]['but_marque'] += calcul_score($classementsNew->score,false);
            $classements[$key]['but_encaisse'] += calcul_score($classementsNew->score,true);
            if ((calcul_resultat($classementsNew->score,false) == 'victoire')){
                $classements[$key]['nb_match_gagne'] ++;
                $classements[$key]['points'] = $classements[$key]['points'] + 3;
            }
            if ((calcul_resultat($classementsNew->score,false) == 'defaite')){
                $classements[$key]['nb_match_perdu'] ++;
            }
            if ((calcul_resultat($classementsNew->score,false) == 'null')){
                $classements[$key]['nb_match_null'] ++;
                $classements[$key]['points'] = $classements[$key]['points'] + 1;
            }
            $classements[$key]['nom']= $classementsNew->equipe2->nom;
        }
    }
    $classements[$key]['difference_but'] = $classements[$key]['but_marque'] - $classements[$key]['but_encaisse'];
}


// Tri du classement

$c_lespoints = array_column($classements,'points');
$c_difference_but = array_column($classements,'difference_but');
$c_but_marque = array_column($classements,'but_marque');

array_multisort($c_lespoints, SORT_DESC, $c_difference_but, SORT_DESC, $c_but_marque, SORT_DESC ,$classements);

    // Attribution du classement
    for ($i=0; $i<20; $i++) {
        $classements[$i]['classement_en_cours']= $i+1;
    }

    return $classements;
    // Fin du classement

}
}
/* resumé :

- nombre de points,
- différence de buts générale
- plus grand nombre de points sur les confrontations directes
- différence de buts particulière


*/


if (!function_exists('remplissage_classement_nom')) {

    function remplissage_classement_nom($equipes, $classementsNews) {
        // Permet d'ajouter le nom de l'équipe quand stats vides

        for ($i=0; $i<20; $i++) {
            if ($classementsNews[$i]['nb_match_joue'] == 0) {
                $classementsNews[$i]['nom'] = 'test';
            }
        }
        foreach ($classementsNews as $key => $classementsNew){
            if($classementsNews[$key]['nom'] == 'test'){
                $classementsNews[$key]['nom'] = $equipes[$key]['nom'];
            }
        }
    return $classementsNews;
    }
}

if (!function_exists('classement_vide')) {

    function classement_vide($classementsNews, $listEquipes, $nomEquipes) {
        // creation des lignes du tableau
        // ajout du noms des équipes
        foreach($listEquipes as $key => $listEquipe){
            $classements[$key]['classement_en_cours']= 0;
            $classements[$key]['points']= 0;
            $classements[$key]['nb_match_joue']= 0;
            $classements[$key]['nb_match_gagne']= 0;
            $classements[$key]['nb_match_null']= 0;
            $classements[$key]['nb_match_perdu']= 0;
            $classements[$key]['but_marque']= 0;
            $classements[$key]['but_encaisse']= 0;
            $classements[$key]['difference_but']= 0;
        }
    }
}