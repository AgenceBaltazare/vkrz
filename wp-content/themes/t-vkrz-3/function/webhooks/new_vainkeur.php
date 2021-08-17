<?php
add_action('user_register', 'new_vainkeur', 10, 1);
function new_vainkeur($user_id){

    $new_user_infos = deal_vainkeur_entry($user_id);
    $user_url       = get_author_posts_url($user_id);

    $url    = "https://hook.integromat.com/uiuymy9i8o09fztl10pkjctqqlwg264w";
    $args   = array(
        'body' => array(
            'id_vainkeur'       => $new_user_infos['id_vainkeur'],
            'user_url'          => $user_url,
            'uuid_user_vkrz'    => $new_user_infos['uuid_user_vkrz'],
            'pseudo'            => $new_user_infos['user_pseudo'],
            'avatar'            => $new_user_infos['avatar_url'],
            'user_email'        => $new_user_infos['user_email'],
            'level'             => $new_user_infos['level'],
            'level_number'      => $new_user_infos['level_number'],
            'nb_vote_vkrz'      => $new_user_infos['nb_vote_vkrz'],
            'nb_top_vkrz'       => $new_user_infos['nb_top_vkrz']
        )
    );
    wp_remote_post($url, $args);

    // Update author for all "classement" where uuid_user_r == vainkeurz_user_id
    if (isset($_COOKIE["vainkeurz_user_id"])) {
        $classements = new WP_Query(array(
                'post_type'              => 'classement',
                'posts_per_page'         => -1,
                'fields'                 => 'ids',
                'post_status'            => 'publish',
                'ignore_sticky_posts'    => true,
                'update_post_meta_cache' => false,
                'no_found_rows'          => false,
                'author__not_in'         => array($user_id),
                'meta_query'             => array(array(
                    'key' => 'uuid_user_r',
                    'value' => $_COOKIE["vainkeurz_user_id"],
                    'compare' => '='
                )),
            ));

        if ($classements->have_posts()) {
            foreach ($classements->posts as $classement) {
                $arg = array(
                    'ID'            => $classement,
                    'post_author'   => $user_id,
                );
                wp_update_post( $arg );
            }
        }
    }

    // Update author for all "vainkeur" where uuid_user_r == vainkeurz_user_id
    if (isset($_COOKIE["vainkeurz_user_id"])) {
        $vainkeur_entry = new WP_Query(array(
                'post_type'              => 'vainkeur',
                'posts_per_page'         => 1,
                'fields'                 => 'ids',
                'post_status'            => 'publish',
                'ignore_sticky_posts'    => true,
                'update_post_meta_cache' => false,
                'no_found_rows'          => false,
                'author__not_in'         => array($user_id),
                'meta_query'             => array(array(
                    'key' => 'uuid_user_vkrz',
                    'value' => $_COOKIE["vainkeurz_user_id"],
                    'compare' => '='
                )),
            ));

        if ($vainkeur_entry->have_posts()) {
            foreach ($vainkeur_entry->posts as $vainkeur_entry_result) {
                $arg = array(
                    'ID'            => $vainkeur_entry_result,
                    'post_author'   => $user_id,
                );
                wp_update_post( $arg );
            }
        }
    }

}