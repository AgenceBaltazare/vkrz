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

function all_moy_votes_in_tournament($id_tournament){

    $ranking_tournament_done = new WP_Query(
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

    $count_votes = 0;

    while($ranking_tournament_done->have_posts()) : $ranking_tournament_done->the_post();

        $count_votes = $count_votes + get_field('nb_votes_r');

    endwhile;

    return $count_votes;

}

?>