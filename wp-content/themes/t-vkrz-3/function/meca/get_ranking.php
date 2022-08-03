<?php
function get_user_ranking_id($id_top, $uuiduser = false, $id_vainkeur = false) {

    if(!$uuiduser){
        $uuiduser = $_COOKIE['vainkeurz_user_id'];
    }

    $id_ranking         = false;
    $have_already_top   = false;

    if (get_field('liste_des_top_vkrz', $id_vainkeur)) {
        if (in_array($id_top, json_decode(get_field('liste_des_top_vkrz', $id_vainkeur)))) {
            $have_already_top = true;
        }
    }
    if (get_field('liste_des_top_commences_vkrz', $id_vainkeur)) {
        if (in_array($id_top, json_decode(get_field('liste_des_top_commences_vkrz', $id_vainkeur)))) {
            $have_already_top = true;
        }
    }

    if(isset($uuiduser) && $uuiduser != "" && $have_already_top == true) {

        $user_ranking = new WP_Query(array(
            'post_type'              => 'classement',
            'posts_per_page'         => '1',
            'fields'                 => 'ids',
            'post_status'            => 'publish',
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'no_found_rows'          => false,
            'meta_query' =>
                array(
                    'relation' => 'AND',
                    array(
                        'key' => 'id_tournoi_r',
                        'value' => $id_top,
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
}
