<?php

function vkrz_push_level_up($user_id, $level_number){

    if($user_id){

        $new_user_infos = deal_vainkeur_entry($user_id);
        $user_url       = get_author_posts_url($user_id);

        switch ($level_number) {
            case $level_number <= 0:
                $level_icon = "🥚";
                break;
            case $level_number == 1:
                $level_icon = "🐣";
                break;
            case $level_number == 2:
                $level_icon = "🐥";
                break;
            case $level_number == 3:
                $level_icon = "🐓";
                break;
            case $level_number == 4:
                $level_icon = "🦃";
                break;
            case $level_number == 5:
                $level_icon = "🦢";
                break;
            case $level_number == 6:
                $level_icon = "🦩";
                break;
            case $level_number == 7:
                $level_icon = "🦚";
                break;
            case $level_number == 8:
                $level_icon = "🐉";
                break;
        }

        if(env() != "local"){
            $url    = "https://hook.integromat.com/5395gfiwt0abf2y7uimxpp329tdnn27s";
            $args   = array(
                'body' => array(
                    'id_vainkeur'       => $new_user_infos['id_vainkeur'],
                    'user_url'          => $user_url,
                    'uuid_user_vkrz'    => $new_user_infos['uuid_user_vkrz'],
                    'pseudo'            => $new_user_infos['pseudo'],
                    'avatar'            => $new_user_infos['avatar'],
                    'user_email'        => $new_user_infos['user_email'],
                    'level'             => $level_icon,
                    'level_number'      => $level_number,
                    'nb_vote_vkrz'      => $new_user_infos['nb_vote_vkrz'],
                    'nb_top_vkrz'       => $new_user_infos['nb_top_vkrz']
                )
            );
            wp_remote_post($url, $args);
        }

    }

}

function vkrz_push_note($note_id){

    if (env() != "local") {
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

}


function vkrz_push_transaction($id_transaction){

    if(env() != "local" && $id_transaction){
        $name_produit       = get_the_title(get_field('id_produit_transaction', $id_transaction));
        $price_produit      = get_field('montant_transaction', $id_transaction);

        $user_id     = get_the_author_meta('ID');
        if ($user_id) {
            $user_info   = get_userdata($user_id);
            $user_pseudo = $user_info->nickname;
        }

        $url    = "https://hook.integromat.com/4uyy4a8q31f2u2vwwellsw8ndjfgjz6n";
        $args   = array(
            'body' => array(
                'name_produit'     => $name_produit,
                'price_produit'    => $price_produit,
                'acheteur_pseudo'  => $user_pseudo,
            )
        );

        wp_remote_post($url, $args);
    }
}


function vkrz_push_event($event){

    if (env() != "local") {
        $url    = "https://hook.integromat.com/t4m1rces3mtdluer1f9g91lemug5497y";
        $args   = array(
            'body' => $event
        );
        
        wp_remote_post($url, $args);
    }

}