<?php
// All total votes in the current tournoi by the current user
function all_user_votes_in_tournament( $id_tournament ) {

    $all_user_votes = new WP_Query( array(
        'post_type'      => 'vote',
        'posts_per_page' => - 1,
        'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key'     => 'id_t_v',
                'value'   => $id_tournament,
                'compare' => '=',
            ),
            array(
                'key'     => 'id_user_v',
                'value'   => $_COOKIE['vainkeurz_user_id'],
                'compare' => '=',
            )
        )
    ) );

    return $all_user_votes->found_posts;
}

// All total votes in the current tournoi
function all_votes_in_tournament( $id_tournament ) {

    $all_votes = new WP_Query( array(
        'post_type'      => 'vote',
        'posts_per_page' => - 1,
        'meta_query'     => array(
            array(
                'key'     => 'id_t_v',
                'value'   => $id_tournament,
                'compare' => '=',
            )
        )
    ) );

    return $all_votes->found_posts;
}
?>