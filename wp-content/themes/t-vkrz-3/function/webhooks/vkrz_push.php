<?php

function vkrz_push_levelup($user_id, $level){

    if($user_id){

        $new_user_infos = deal_vainkeur_entry($user_id);
        $user_url       = get_author_posts_url($user_id);

        $url    = "https://hook.integromat.com/5395gfiwt0abf2y7uimxpp329tdnn27s";
        $args   = array(
            'body' => array(
                'id_vainkeur'       => $new_user_infos['id_vainkeur'],
                'user_url'          => $user_url,
                'uuid_user_vkrz'    => $new_user_infos['uuid_user_vkrz'],
                'pseudo'            => $new_user_infos['pseudo'],
                'avatar'            => $new_user_infos['avatar'],
                'user_email'        => $new_user_infos['user_email'],
                'level'             => $new_user_infos['level'],
                'level_number'      => $level,
                'nb_vote_vkrz'      => $new_user_infos['nb_vote_vkrz'],
                'nb_top_vkrz'       => $new_user_infos['nb_top_vkrz']
            )
        );
        wp_remote_post($url, $args);

    }

}