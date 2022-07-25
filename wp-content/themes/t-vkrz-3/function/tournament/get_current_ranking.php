<?php
function get_current_user_ranking($id_ranking){

    $current_user_ranking   = array();
    $list_contenders        = get_field('ranking_r', $id_ranking);
    $nb_contenders          = count($list_contenders);

    foreach($list_contenders as $contender) {

        $counter = count($contender['more_to']) + count($contender['less_to']);

        if($counter == ($nb_contenders - 1)){

            $place = count($contender['less_to']) + 1;

            array_push($current_user_ranking, array(
                "id_wp"             => $contender['id_wp'],
                "place"             => $place
            ));

        }

    }

    return $current_user_ranking;
}