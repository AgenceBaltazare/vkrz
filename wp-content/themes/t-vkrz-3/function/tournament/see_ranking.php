<?php
function get_user_ranking($id_ranking, $dimension = false){

    $list_contenders = get_field('ranking_r', $id_ranking);
    $typetop         = get_field('type_top_r', $id_ranking);
    array_sort_by_column($list_contenders, 'place');
    $user_ranking    = array_column($list_contenders, 'place', 'id_wp');

    if($dimension){
        $result = array_slice($user_ranking, 0, $dimension, true);
    }
    else{
        if($typetop == 'top3'){
            $result = array_slice($user_ranking, 0, 3, true);
        }
        else{
            $result = $user_ranking;
        }
    }

    return $result;
}