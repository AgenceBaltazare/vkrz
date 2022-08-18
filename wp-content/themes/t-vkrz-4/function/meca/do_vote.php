<?php
function do_vote($id_winner, $id_looser, $id_ranking, $id_top){

    $key_vainkeur    = 0;
    $key_loser       = 0;
    $already_sup_to  = array();
    $already_inf_to  = array();
    $list_w_r        = get_field('list_winners_r', $id_ranking);
    if(!$list_w_r){
        $list_w_r    = array();
    }
    $list_l_r        = get_field('list_losers_r', $id_ranking);
    if(!$list_l_r){
        $list_l_r    = array();
    }
    $nb_winners      = count($list_w_r);
    $nb_loosers      = count($list_l_r);
    $list_contenders = get_field('ranking_r', $id_ranking);
    $nb_contenders   = count($list_contenders);
    $timeline_main   = get_field('timeline_main', $id_ranking);

    // On ajoute un vote au compteur
    if($id_winner && $id_looser){
        $nb_votes_r      = get_field('nb_votes_r', $id_ranking);
        $nb_votes_r      = $nb_votes_r + 1;
        update_field('nb_votes_r', $nb_votes_r, $id_ranking);
    }

    // On boucle sur le ranking pour connaître la position dans le tableau du gagnant et du perdant
    foreach($list_contenders as $key => $contender) {

        if($contender['id_wp'] == $id_winner){
            $key_vainkeur     = $key;
        }

        if($contender['id_wp'] == $id_looser){
            $key_loser     = $key;
        }

    }

    // On boucle sur le ranking pour connaître tous les participants qui ont l'ID du gagnant dans le tableau de leur paramètre "more_to"
    // On stocke dans la variable "$already_sup_to" la liste des participants(keys) qui ont battu le gagnant
    foreach($list_contenders as $key => $contender) {
        if(in_array($key_vainkeur, $contender['more_to'])){
            array_push($already_sup_to, $key);
        }
        if(in_array($key_loser, $contender['less_to'])){
            array_push($already_inf_to, $key);
        }
    }

    // On ajoute le gagnant dans la liste de ceux qui l'ont déjà battu
    if($id_winner){

        array_push($already_sup_to, $key_vainkeur);

        // On récupère la liste des participants battu par le perdant du duel
        $list_sup_to_l = $list_contenders[$key_loser]['more_to'];

        // On stocke les vainkeurz de l'étape 1
        if($timeline_main == 1){
            array_push($list_w_r, $id_winner);
            update_field('list_winners_r', $list_w_r, $id_ranking);
        }

    }
    // On ajoute le perdant dans la liste de ceux qui l'ont déjà battu
    if($id_looser){

        array_push($already_inf_to, $key_loser);

        // On récupère la liste des participants qui battent par le gagnant du duel
        $list_inf_to_v = $list_contenders[$key_vainkeur]['less_to'];

        // On stocke les perdants de l'étape 1
        if($timeline_main == 1){
            array_push($list_l_r, $id_looser);
            update_field('list_losers_r', $list_l_r, $id_ranking);
        }

    }

    // On boucle sur la liste des participant battant le perdant
    // Cela inclus le gagnant du duel + tout ceux qui ont déjà battu ce gagnant
    foreach (array_unique($already_sup_to) as $k){

        // On récupère la liste des participants que ce participant bat
        $to_up_sup_to = $list_contenders[$k]['more_to'];

        // On ajoute à cette liste, l'ID du perdant du duel
        array_push($to_up_sup_to, $key_loser);

        // Si il s'agit du gagnant du duel alors on fusionne les deux liste des participants battu par le gagnant et le perdant
        // Puis modifie la liste "more_to" du gagnant avec cette nouvelle liste
        // Si c'est un autre participant qui a déjà battu le vainkeurz alors on ajoute juste
        $total_sup_to = array_merge($list_sup_to_l, $to_up_sup_to);
        $list_contenders[$k]['more_to'] = array_unique($total_sup_to);

        // On compte le nombre de personne que le participant bat
        $count_sup_of     = count($list_contenders[$k]['more_to']);
        $new_place        = $count_sup_of;

        // On compte le nombre de personne qui battent le participant
        $count_inf_of     = count($list_contenders[$k]['less_to']);
        $ratio            = $count_sup_of - $count_inf_of;

        // On modifie la valeur de sa place et son ratio avec cette nouvelle valeur
        $list_contenders[$k]['place']    = $new_place;
        $list_contenders[$k]['ratio']    = $ratio;

    }

    // On boucle sur la liste des participant perdant contre le perdant
    // Cela inclus le perdant du duel + tout ceux qui battent déjà ce perdant
    foreach (array_unique($already_inf_to) as $k){

        // On récupère la liste des participants qui le battent
        $to_up_inf_to = $list_contenders[$k]['less_to'];

        // On ajoute à cette liste, l'ID du gagnant du duel
        array_push($to_up_inf_to, $key_vainkeur);

        // Si il s'agit du perdant du duel alors on fusionne les deux liste des participants qui battent par le gagnant et le perdant
        // Puis modifie la liste "less_to" du perdant avec cette nouvelle liste
        $total_inf_to = array_merge($list_inf_to_v, $to_up_inf_to);
        $list_contenders[$k]['less_to'] = array_unique($total_inf_to);

        // On compte le nombre de personne que le participant bat
        $count_sup_of     = count($list_contenders[$k]['more_to']);

        // On compte le nombre de personne qui battent le participant
        $count_inf_of     = count($list_contenders[$k]['less_to']);
        $ratio            = $count_sup_of - $count_inf_of;

        // On modifie la valeur de son ratio avec cette nouvelle valeur
        $list_contenders[$k]['ratio']    = $ratio;

    }

    // On enregistre la mise à jour du champs "Ranking" du classement en cours
    update_field("ranking_r", $list_contenders, $id_ranking);

    mouv_timeline($nb_contenders, $nb_loosers, $id_ranking, $id_top);

}