<?php

function deal_vainkeur_entry($user_id = false){

    global $uuiduser;
    $id_vainkeur    = false;
    $uuid_user_vkrz = false;

    if(!$user_id) {
        global $user_id;
    }

    $nb_vote_vkrz           = 0;
    $nb_top_vkrz            = 0;
    $money_vkrz             = 0;
    $money_createur_vkrz    = 0;
    $current_money_vkrz     = 0;

    if($user_id){
        $args_author__in = array($user_id);
        $args_meta_query = array();
    }
    else{
        $args_author__in = array();
        $args_meta_query = array(
            array(
                'key' => 'uuid_user_vkrz',
                'value' => $uuiduser,
                'compare' => '='
            )
        );
    }

    $vainkeur_entry = new WP_Query(array(
        'post_type'              => 'vainkeur',
        'posts_per_page'         => '1',
        'fields'                 => 'ids',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'meta_query'             => $args_meta_query,
        'author__in'             => $args_author__in,
    ));

    if($vainkeur_entry->have_posts()){

        $id_vainkeur    = $vainkeur_entry->posts[0];

        $uuid_user_vkrz = get_field('uuid_user_vkrz', $id_vainkeur);
        $nb_vote_vkrz   = get_field('nb_vote_vkrz', $id_vainkeur);
        $nb_top_vkrz    = get_field('nb_top_vkrz', $id_vainkeur);
        $money_vkrz     = get_field('money_vkrz', $id_vainkeur);
        $money_createur_vkrz = get_field('money_creator_vkrz', $id_vainkeur);
        $current_money_vkrz  = get_current_money($id_vainkeur);

    }
    else{

        $rank_entry = new WP_Query(array(
            'post_type'              => 'classement',
            'posts_per_page'         => '1',
            'fields'                 => 'ids',
            'post_status'            => 'publish',
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'no_found_rows'          => false,
            'meta_query'             => array(
                array(
                    'key' => 'uuid_user_r',
                    'value' => $uuiduser,
                    'compare' => '='
                )
            )
        ));
        if($rank_entry->have_posts()){

            $new_vainkeur_entry = array(
                'post_type'   => 'vainkeur',
                'post_title'  => $uuiduser,
                'post_status' => 'publish',
            );
            $id_vainkeur  = wp_insert_post($new_vainkeur_entry);
    
            update_field('uuid_user_vkrz', $uuiduser, $id_vainkeur);
            update_field('nb_vote_vkrz', 0, $id_vainkeur);
            update_field('nb_top_vkrz', 0, $id_vainkeur);

        }
    }

    if(!$id_vainkeur){
        $id_vainkeur = false;
    }
    if(!$uuid_user_vkrz){
        $uuid_user_vkrz = $uuiduser;
    }

    $user_pseudo         = "";
    $user_email          = "";
    $user_role           = "";

    if($user_id){
        $user_info       = get_userdata($user_id);
        $user_pseudo     = $user_info->nickname;
        $user_email      = $user_info->user_email;
        $user_role       = $user_info->roles[0];
    }
    
    $avatar_url      = get_avatar_url($user_id, ['size' => '80', 'force_default' => false]);

    $info_user_level = get_user_level($user_id);

    return array(
        'id_vainkeur'       => $id_vainkeur,
        'uuid_user_vkrz'    => $uuid_user_vkrz,
        'pseudo'            => $user_pseudo,
        'avatar'            => $avatar_url,
        'user_email'        => $user_email,
        'user_role'         => $user_role,
        'level'             => $info_user_level['level_ico'],
        'level_number'      => $info_user_level['level_number'],
        'next_level'        => $info_user_level['next_level'],
        'nb_vote_vkrz'      => $nb_vote_vkrz,
        'nb_top_vkrz'       => $nb_top_vkrz,
        'money_vkrz'        => $money_vkrz,
        'money_creator_vkrz' => $money_createur_vkrz,
        'current_money_vkrz' => $current_money_vkrz
    );

}