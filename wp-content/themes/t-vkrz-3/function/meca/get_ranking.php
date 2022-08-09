<?php
function get_user_ranking_id($id_top, $uuid_vainkeur, $id_vainkeur) {

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

    if($have_already_top == true) {

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
                        'key'       => 'id_tournoi_r',
                        'value'     => $id_top,
                        'compare'   => '=',
                    ),
                    array(
                        'key'       => 'uuid_user_r',
                        'value'     => $uuid_vainkeur,
                        'compare'   => '=',
                    )
                )
            )
        );
        if ($user_ranking->have_posts()) {
            $id_ranking = $user_ranking->posts[0];
        }
    }
    return $id_ranking;
}
