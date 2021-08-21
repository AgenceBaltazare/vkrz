<?php

function vkrz_push_level_up($user_id, $level){

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

function vkrz_push_note($note_id){

    $noteur_id          = get_post_field('post_author', $note_id);
    $noteur_data        = get_user_by('ID', $noteur_id);
    $noteur_name        = $noteur_data->nickname;
    $noteur_profil      = get_author_posts_url($noteur_id);
    $noteur_uuid        = get_field('id_user_n', $note_id);
    $note_value         = get_field('id_s_n', $note_id);
    $note_comment       = get_field('commentaire_n', $note_id);
    $id_top             = get_field('id_t_n', $note_id);
    $top_infos_to_send  = get_top_infos($id_top);
    $top_title          = "Top ".$top_infos_to_send['top_number']." ⚡️ ".$top_infos_to_send['top_title']." - ".$top_infos_to_send['top_question'];
    $top_url            = get_the_permalink($id_top);

    $url    = "https://hook.integromat.com/joa9qaowupcroxayiq4lvef5k2155n3n";
    $args   = array(
        'body' => array(
            'top_title'     => $top_title,
            'top_url'       => $top_url,
            'note_id'       => $note_id,
            'note_value'    => $note_value,
            'note_comment'  => $note_comment,
            'noteur'        => array(
                'pseudo'    => $noteur_name,
                'profil'    => $noteur_profil,
                'uuid'      => $noteur_uuid,
            )
        )
    );

    wp_remote_post($url, $args);

}


function vkrz_push_event($event){

    $url    = "https://hook.integromat.com/t4m1rces3mtdluer1f9g91lemug5497y";
    $args   = array(
        'body' => $event
    );
    
    wp_remote_post($url, $args);

}