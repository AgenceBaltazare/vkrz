<?php
function get_user_ranking($id_ranking, $dimension = false){

    $list_contenders = get_field('ranking_r', $id_ranking);
    $typetop         = get_field('type_top_r', $id_ranking);
    $result          = array();
    array_sort_by_column($list_contenders, 'place');
    $user_ranking    = array_column($list_contenders, 'place', 'id_wp');

    if($dimension){
        $rank = array_slice($user_ranking, 0, $dimension, true);
    }
    else{
        if($typetop == 'top3'){
            $rank = array_slice($user_ranking, 0, 3, true);
        }
        else{
            $rank = $user_ranking;
        }
    }

    foreach ($rank as $contender => $p) {
        array_push(
            $result,
            $contender
        );
    }

    return $result;
}