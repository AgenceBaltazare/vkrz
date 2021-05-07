<?php
function get_user_data($request, $uuiduser){

    if($request == "nb-user-vote"){

        $all_user_votes = new WP_Query(array('post_type' => 'vote', 'posts_per_page' => '-1', 'meta_query' => array(
            array(
                'key' => 'uuid_user_r',
                'value' => $uuiduser,
                'compare' => '=',
            ),
        )));

        $result  = $all_user_votes->post_count;

    }

    return $result;

}

function get_user_tournament_list($request, $uuiduser){

    if($request == "t-done"){

        $result = array();
        $all_user_ranking = new WP_Query(array('post_type' => 'classement', 'posts_per_page' => '-1', 'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'uuid_user_r',
                'value' => $uuiduser,
                'compare' => '=',
            ),
            array(
                'key' => 'done_r',
                'value' => 'done',
                'compare' => '=',
            ),
        )));
        while ($all_user_ranking->have_posts()) : $all_user_ranking->the_post();

            array_push($result, get_field('id_tournoi_r'));

        endwhile;

    }

    return $result;

}