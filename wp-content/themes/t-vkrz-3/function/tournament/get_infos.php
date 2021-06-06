<?php

// Get numbers of contenders in a tournament
function get_numbers_of_contenders($id_tournament) {

    $contenders_tournament = new WP_Query(
        array(
            'post_type'      => 'contender',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => 'id_tournoi_c',
                    'value'   => $id_tournament,
                    'compare' => '=',
                )
            )
        )
    );

    $nb_contenders = $contenders_tournament->post_count;

    return $nb_contenders;
}

// Get numbers of ranking in a tournament
function get_numbers_of_ranking($id_tournament) {

    $nb_ranking_tournament = new WP_Query(
        array(
            'post_type'      => 'classement',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => 'id_tournoi_r',
                    'value'   => $id_tournament,
                    'compare' => '=',
                )
            )
        )
    );

    $nb_ranking = $nb_ranking_tournament->post_count;

    return $nb_ranking;
}

// Get numbers of ranking done in a tournament
function get_numbers_of_ranking_done($id_tournament) {

    $nb_ranking_tournament_done = new WP_Query(
        array(
            'post_type'      => 'classement',
            'posts_per_page' => -1,
            'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key'     => 'id_tournoi_r',
                    'value'   => $id_tournament,
                    'compare' => '=',
                ),
                array(
                    'key' => 'done_r',
                    'value' => 'done',
                    'compare' => '=',
                ),
            )
        )
    );

    $nb_ranking_done = $nb_ranking_tournament_done->post_count;

    return $nb_ranking_done;
}