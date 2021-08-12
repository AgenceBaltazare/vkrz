<?php
function deal_vainkeur_entry($uuidusertofind = false){

    global $user_id;

    if(!$uuidusertofind){
        global $uuiduser;
    }

    $nb_vote_vkrz = 0;
    $nb_top_vkrz  = 0;

    if($uuidusertofind){
        $args_author__in = array($uuidusertofind);
        $args_meta_query = array();
    }
    elseif($user_id){
        $args_author__in = array($user_id);
        $args_meta_query = array();
    }
    else{
        $args_author__in = array();
        $args_meta_query = array(
            'key' => 'uuid_user_vkrz',
            'value' => $uuiduser,
            'compare' => '='
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

    }
    else{

        $new_vainkeur_entry = array(
            'post_type'   => 'vainkeur',
            'post_title'  => $uuiduser,
            'post_status' => 'publish',
        );
        $id_vainkeur  = wp_insert_post($new_vainkeur_entry);

        update_field('uuid_user_vkrz', 0, $id_vainkeur);
        update_field('nb_vote_vkrz', 0, $id_vainkeur);
        update_field('nb_top_vkrz', 0, $id_vainkeur);

    }

    $user_info      = get_userdata($user_id);
    $user_pseudo    = $user_info->nickname;
    $user_email     = $user_info->user_email;
    $user_role      = $user_info->roles[0];

    $avatar_url  = get_avatar_url($user_id, ['size' => '80']);
    if(!$avatar_url){
        $avatar_url = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
    }
    $info_user_level = get_user_level();

    $result = array(
        'id_vainkeur'       => $id_vainkeur,
        'uuid_user_vkrz'    => $uuid_user_vkrz,
        'pseudo'            => $user_pseudo,
        'avatar'            => $avatar_url,
        'user_email'        => $user_email,
        'user_role'         => $user_role,
        'level'             => $info_user_level['level_ico'],
        'next_level'        => $info_user_level['next_level'],
        'nb_vote_vkrz'      => $nb_vote_vkrz,
        'nb_top_vkrz'       => $nb_top_vkrz
    );

    return $result;

}