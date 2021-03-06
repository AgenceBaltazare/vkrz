<?php

// Get numbers of contenders in a tournament
function get_numbers_of_contenders($id_tournament) {

    $contenders_tournament = new WP_Query(
        array(
            'post_type'              => 'contender',
            'posts_per_page'         => '300',
            'fields'                 => 'ids',
            'post_status'            => 'publish',
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'no_found_rows'          => false,
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