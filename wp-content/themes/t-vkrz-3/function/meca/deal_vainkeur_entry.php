<?php
function deal_vainkeur_entry($uuiduser){

    global $nb_vote_vkrz;
    global $nb_top_vkrz;
    global $user_id;

    $vainkeur_entry = new WP_Query(array(
        'post_type'              => 'vainkeur',
        'posts_per_page'         => '1',
        'fields'                 => 'ids',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'meta_query' =>
            array(
                'key' => 'uuid_user_vkrz',
                'value' => $uuiduser,
                'compare' => '=',
            )
        )
    );

    if($vainkeur_entry->have_posts()){

        $id_vainkeur    = $vainkeur_entry->post;
        $nb_vote_vkrz   = get_field('nb_vote_vkrz', $id_vainkeur);
        $nb_top_vkrz    = get_field('nb_top_vkrz', $id_vainkeur);

        $user_full_data  = is_user_logged_in() ? get_user_full_data($user_id, "author") : get_user_full_data($uuiduser);
        $nb_top_vkrz     = count($user_full_data[0]['list_user_ranking_done']);
        $nb_vote_vkrz    = $user_full_data[0]['nb_user_votes'];

        update_field('uuid_user_vkrz', $uuiduser, $id_vainkeur);
        update_field('nb_vote_vkrz', $nb_vote_vkrz, $id_vainkeur);
        update_field('nb_top_vkrz', $nb_top_vkrz, $id_vainkeur);

    }
    else{

        $new_vainkeur_entry = array(
            'post_type'   => 'vainkeur',
            'post_title'  => $uuiduser,
            'post_status' => 'publish',
        );
        $id_vainkeur  = wp_insert_post($new_vainkeur_entry);

        $user_full_data  = is_user_logged_in() ? get_user_full_data($user_id, "author") : get_user_full_data($uuiduser);
        $nb_top_vkrz     = count($user_full_data[0]['list_user_ranking_done']);
        $nb_vote_vkrz    = $user_full_data[0]['nb_user_votes'];

        update_field('uuid_user_vkrz', $uuiduser, $id_vainkeur);
        update_field('nb_vote_vkrz', $nb_vote_vkrz, $id_vainkeur);
        update_field('nb_top_vkrz', $nb_top_vkrz, $id_vainkeur);

    }

    $result = array(
        array(
            'uuid_user_vkrz'    => $id_vainkeur,
            'nb_vote_vkrz'      => $nb_vote_vkrz,
            'nb_top_vkrz'       => $nb_top_vkrz
        )
    );

    return $result;

}