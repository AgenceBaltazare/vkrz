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