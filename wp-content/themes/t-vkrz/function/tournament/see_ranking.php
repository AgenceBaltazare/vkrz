<?php
function get_user_ranking($id_ranking){

    $list_contenders = get_field('ranking_r', $id_ranking);
    array_sort_by_column($list_contenders, 'place');
    $user_ranking = array_column($list_contenders, 'place', 'id_wp');

    return $user_ranking;

}

function get_user_vainkeur($id_ranking){

    $list_contenders = get_field('ranking_r', $id_ranking);
    array_sort_by_column($list_contenders, 'place');
    $user_ranking = array_column($list_contenders, 'place', 'id_wp');

    return array_key_first($user_ranking);

}