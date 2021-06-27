<?php
function get_user_ranking($id_ranking, $dimension = false){

    $list_contenders = get_field('ranking_r', $id_ranking);
    $typetop         = get_field('type_top_r', $id_ranking);
    array_sort_by_column($list_contenders, 'place');
    $user_ranking = array_column($list_contenders, 'place', 'id_wp');

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

function get_user_vainkeur($id_ranking){

    $list_contenders = get_field('ranking_r', $id_ranking);
    array_sort_by_column($list_contenders, 'place');
    $user_ranking = array_column($list_contenders, 'place', 'id_wp');

    return array_key_first($user_ranking);

}

function get_elo_vainkeur($id_tournament){

    $id_vainkeur_elo = 13;

    $contenders_tournament = new WP_Query(array(
        'post_type' => 'contender',
        'meta_key' => 'ELO_c',
        'orderby' => 'meta_value',
        'posts_per_page' => 1,
        'meta_query' => array(
        array(
            'key'     => 'id_tournoi_c',
            'value'   => $id_tournament,
            'compare' => '=',
        )
    )));
    while ($contenders_tournament->have_posts()) : $contenders_tournament->the_post();

        $id_vainkeur_elo = get_the_ID();

    endwhile;

    $contenders_tournament->reset_postdata();
    wp_reset_query();

    return $id_vainkeur_elo;

}