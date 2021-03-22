<?php

// All total votes in the current tournoi by the current user
function all_user_votes_in_tournament($id_ranking) {

    $all_user_votes = 0;
    $all_user_votes = get_field('nb_votes_r', $id_ranking);
    if(!$all_user_votes){
        $all_user_votes = 0;
    }

    return $all_user_votes;
}

// All total votes in the current tournoi
function all_votes_in_tournament( $id_tournament ) {

    $all_votes = new WP_Query( array(
        'post_type'      => 'vote',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => 'id_t_v',
                'value'   => $id_tournament,
                'compare' => '=',
            )
        )
    ) );

    return $all_votes->post_count;
}
?>