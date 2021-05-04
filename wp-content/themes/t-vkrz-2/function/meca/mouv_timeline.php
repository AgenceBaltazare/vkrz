<?php
function mouv_timeline($nb_contenders, $nb_loosers, $id_ranking){

    // NB votes
    $timeline_votes     = get_field('nb_votes_r', $id_ranking);
    if($nb_contenders % 2 == 0){
        $spaire = 5;
    }
    else{
        $spaire = 6;
    }

    // Timeline Main
    if($timeline_votes == $nb_contenders-5){
        update_field('timeline_main', 2, $id_ranking);
    }
    $timeline_main = get_field('timeline_main', $id_ranking);


    if($timeline_main == 2){
        $timeline_2      = get_field('timeline_2', $id_ranking);
        $timeline_2      = $timeline_2 + 1;
        update_field('timeline_2', $timeline_2, $id_ranking);

        if($timeline_2 == $nb_loosers){
            update_field('timeline_main', 3, $id_ranking);
        }
    }
    if($timeline_main == 3){
        update_field('timeline_main', 4, $id_ranking);
    }
    if($timeline_main == 4){
        $timeline_4      = get_field('timeline_4', $id_ranking);
        $timeline_4      = $timeline_4 + 1;
        update_field('timeline_4', $timeline_4, $id_ranking);

        if($timeline_4 == $spaire){
            update_field('timeline_main', 5, $id_ranking);
        }
    }

    $timeline_main = get_field('timeline_main', $id_ranking);

    return $timeline_main;

}