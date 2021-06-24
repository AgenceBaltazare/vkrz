<?php
function get_or_create_ranking_if_not_exists($id_tournament, $uuiduser = false) {

    if(!$uuiduser){
        $uuiduser = $_COOKIE['vainkeurz_user_id'];
    }

    $id_ranking = false;

    if(isset($uuiduser) && $uuiduser != "") {

        // Get user ranking
        $user_ranking = new WP_Query(array(
                'post_type' => 'classement',
                'posts_per_page' => '1',
                'ignore_sticky_posts' => true,
                'update_post_meta_cache' => false,
                'fields' => 'ids',
                'no_found_rows' => true,
                'meta_query' =>
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'id_tournoi_r',
                            'value' => $id_tournament,
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'uuid_user_r',
                            'value' => $uuiduser,
                            'compare' => '=',
                        )
                    )
            )
        );
        if ($user_ranking->have_posts()) {
            while ($user_ranking->have_posts()) : $user_ranking->the_post();
                $id_ranking = get_the_ID();
            endwhile;
        }
    }

    return $id_ranking;

    wp_reset_postdata();
}
?>