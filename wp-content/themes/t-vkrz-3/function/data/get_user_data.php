<?php

function get_user_logged_id(){

    if(is_user_logged_in()){
        $current_user   = wp_get_current_user();
        $user_id        = $current_user->ID;
    }
    else{
        $user_id = false;
    }

    return $user_id;
}

function get_user_infos($uuiduser){

    $id_vainkeur        = false;
    $user_id            = false;
    $user_pseudo        = "";
    $avatar_url         = "";
    $user_role          = "";
    $user_email         = "";
    $nb_top_vkrz        = 0;
    $nb_vote_vkrz       = 0;
    $money_vkrz         = 0;
    $current_money_vkrz = 0;
    $money_createur_vkrz= 0;
    $info_user_level    = array(
        "level_ico"     => "",
        "level_number"  => "",
        "next_level"    => "",
    );

    $vainkeur_entry = new WP_Query(array(
        'post_type'              => 'vainkeur',
        'posts_per_page'         => '1',
        'fields'                 => 'ids',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'meta_query'             => array(
            array(
                'key' => 'uuid_user_vkrz',
                'value' => $uuiduser,
                'compare' => '='
            )
        ),
    ));

    if($vainkeur_entry->have_posts()){

        $id_vainkeur    = $vainkeur_entry->posts[0];
        $nb_vote_vkrz   = get_field('nb_vote_vkrz', $id_vainkeur);
        $nb_top_vkrz    = get_field('nb_top_vkrz', $id_vainkeur);
        $money_vkrz     = get_field('money_vkrz', $id_vainkeur);
        $money_createur_vkrz = get_field('money_creator_vkrz', $id_vainkeur);
        $current_money_vkrz = get_current_money($id_vainkeur);

    }

    if($id_vainkeur){

        $user_id         = get_post_field('post_author', $id_vainkeur);
        $user_info       = get_userdata($user_id);
        $user_pseudo     = $user_info->nickname;
        $user_email      = $user_info->user_email;
        $user_role       = $user_info->roles[0];
        $avatar_url      = get_avatar_url($user_id, ['size' => '80', 'force_default' => false]);
        $info_user_level = get_user_level($user_id);

    }

    return array(
        'id_vainkeur'       => $id_vainkeur,
        'user_id'           => $user_id,
        'uuid_user_vkrz'    => $uuiduser,
        'profil_url'        => get_author_posts_url($user_id),
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

function get_user_tops($user_id = false){

   

    return array(
        "list_user_tops"            => array('44'),
        "list_user_tops_done_ids"   =>
        array('44')
    );
}

function get_vkrz_users_list($limit = false){

    $result = array();

    $user_query = new WP_User_Query(array('number' => -1));
    $users_list = $user_query->get_results();

    foreach($users_list as $user){

        $user_ID    = $user->ID;

        array_push($result, $user_ID);

    }

    if($limit){
        $result = array_slice($result, 0, $limit);
    }

    return $result;

}

function find_vkrz_user($uuid_user_r){

    $result = array();

    $user_search = new WP_User_Query(array(
        'number' => 1,
        'meta_query' => array(
            array(
                'key'     => 'uuiduser_user',
                'value'   => $uuid_user_r,
                'compare' => '=',
            )
        )
    ));

    $user_found = $user_search->get_results();

    foreach($user_found as $user){

        $user_id         = $user->ID;
        $user_info       = get_userdata($user_id);
        $user_pseudo     = $user_info->nickname;
        $user_email      = $user_info->user_email;
        $user_role       = $user_info->roles[0];

        $avatar_url      = get_avatar_url($user_id, ['size' => '80', 'force_default' => false]);

        $info_user_level = get_user_level($user_id);

        $result = array(
            'id_vainkeur'       => $user_id,
            'pseudo'            => $user_pseudo,
            'avatar'            => $avatar_url,
            'user_email'        => $user_email,
            'user_role'         => $user_role,
            'level'             => $info_user_level['level_ico'],
            'level_number'      => $info_user_level['level_number'],
            'next_level'        => $info_user_level['next_level']
        );

    }

    return $result;

}

function get_user_level($user_id = false){

    if(!$user_id){
        global $user_id;
    }
    
    if(!$user_id){
        $level_number = false;
    }
    else{
        $level_number = get_field('level_user', 'user_' . $user_id);
    }
    
    switch($level_number){

        case 0 || false:
            $level          = '<span class="va va-z-20 va-egg"></span>';
            $level_number   = 0;
            $next_level     = '<span class="va va-z-20 va-hatching-chick"></span>';
            break;
        case 1 :
            $level          = '<span class="va va-z-20 va-hatching-chick"></span>';
            $level_number   = 1;
            $next_level     = '<span class="va va-z-20 va-chick"></span>';
            break;
        case 2 :
            $level          = '<span class="va va-z-20 va-chick"></span>';
            $level_number   = 2;
            $next_level     = '<span class="va va-z-20 va-rooster"></span>';
            break;
        case 3 :
            $level          = '<span class="va va-z-20 va-rooster"></span>';
            $level_number   = 3;
            $next_level     = '<span class="va va-z-20 va-turkey"></span>';
            break;
        case 4 :
            $level          = '<span class="va va-z-20 va-turkey"></span>';
            $level_number   = 4;
            $next_level     = '<span class="va va-z-20 va-swan"></span>';
            break;
        case 5 :
            $level          = '<span class="va va-z-20 va-swan"></span>';
            $level_number   = 5;
            $next_level     = '<span class="va va-z-20 va-flamingo"></span>';
            break;
        case 6 :
            $level          = '<span class="va va-z-20 va-flamingo"></span>';
            $level_number   = 6;
            $next_level     = '<span class="va va-z-20 va-peacock"></span>';
            break;
        case 7 :
            $level          = '<span class="va va-z-20 va-peacock"></span>';
            $level_number   = 7;
            $next_level     = '<span class="va va-z-20 va-dragon"></span>';
            break;
        case 8 :
            $level          = '<span class="va va-z-20 va-dragon"></span>';
            $level_number   = 8;
            $next_level     = false;
            break;
    }

    $result = array(
        "level_ico"       => $level,
        "level_number"    => $level_number,
        "next_level"      => $next_level
    );

    return $result;

}

function get_vote_to_next_level($level_number, $nb_vote_vkrz){

    // Level values
    $niv_1 = 50;
    $niv_2 = 500;
    $niv_3 = 2000;
    $niv_4 = 5000;
    $niv_5 = 35000;
    $niv_6 = 100000;
    $niv_7 = 450000;
    $niv_8 = 1000000;

    switch ($level_number){
        case 0 :
            $value_require_to_level = $niv_1;
            break;
        case 1 :
            $value_require_to_level = $niv_2;
            break;
        case 2 :
            $value_require_to_level = $niv_3;
            break;
        case 3 :
            $value_require_to_level = $niv_4;
            break;
        case 4 :
            $value_require_to_level = $niv_5;
            break;
        case 5 :
            $value_require_to_level = $niv_6;
            break;
        case 6 :
            $value_require_to_level = $niv_7;
            break;
        case 7 :
            $value_require_to_level = $niv_8;
            break;
    }

    $votes_to_next_level  = $value_require_to_level - $nb_vote_vkrz;

    return $votes_to_next_level;

}

function get_creators_ids(){

    $result = array();

    $list_tops = new WP_Query(array(
        'post_type' => 'tournoi',
        'orderby' => 'date',
        'posts_per_page' => '-1',
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => array('onboarding', 'whitelabel', 'private'),
                'operator' => 'NOT IN',
            )
        ),
    ));
    while ($list_tops->have_posts()) : $list_tops->the_post();
        $creator_id    = get_post_field('post_author', get_the_ID());
        array_push($result, $creator_id);
    endwhile;

    return $result;
}

function get_creator_t($creator_id){

    $list_creator_tops  = array();
    $creator_data       = get_user_by('ID', $creator_id);
    $nb_votes_all_t     = 0;
    $nb_ranks_all_t     = 0;
    $total_nb_completed_top     = 0;

    $list_tops = new WP_Query(array(
        'post_type'              => 'tournoi',
        'orderby'                => 'date',
        'posts_per_page'         => '-1',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'author'                 => $creator_id,
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => array('onboarding', 'private', 'whitelabel'),
                'operator' => 'NOT IN',
            )
        ),
    ));
    while($list_tops->have_posts()) : $list_tops->the_post();

        $id_top        = get_the_ID();
        $top_data      = get_top_data($id_top);
        $nb_votes_t    = $top_data['nb_votes'];
        $nb_ranks_t    = $top_data['nb_tops'];
        $nb_completed_top = $top_data['nb_completed_top'];

        $nb_votes_all_t = $nb_votes_all_t + $nb_votes_t;
        $nb_ranks_all_t = $nb_ranks_all_t + $nb_ranks_t;
        $total_nb_completed_top = $total_nb_completed_top + $nb_completed_top;

        array_push($list_creator_tops, array(
            "top_id"        => $id_top,
            "top_title"     => get_the_title($id_top),
            "nb_top"        => get_field('count_contenders_t', $id_top),
            "top_votes"     => $nb_votes_t,
            "top_ranks"     => $nb_ranks_t,
            "top_completed" => $nb_completed_top,
        ));
    endwhile;

    $avatar_url      = get_avatar_url($creator_id, ['size' => '80', 'force_default' => false]);
    $info_user_level = get_user_level($creator_id);
    
    return array(
        "creator_id"        => $creator_id,
        "creator_link"      => get_author_posts_url($creator_id),
        "creator_name"      => $creator_data->nickname,
        "creator_avatar"    => $avatar_url,
        "creator_nb_tops"   => count($list_creator_tops),
        "creator_tops"      => $list_creator_tops,
        "creator_level"     => array(
            "level_ico"     => $info_user_level['level_ico'],
            "level_number"  => $info_user_level['level_number'],
        ),
        "creator_role"      => $creator_data->roles[0],
        "creator_all_v"     => $nb_votes_all_t,
        "creator_all_t"     => $nb_ranks_all_t,
        "total_completed_top" => $total_nb_completed_top,
    );

}

function get_top_done_by_current_vainkeur($id_top, $id_vainkeur){

    $id_rank   = false;
    $uuid_user = get_field('uuid_user_vkrz', $id_vainkeur);

    $check_rank = new WP_Query(array(
        'post_type'                 => 'classement',
        'posts_per_page'            => 1,
        'ignore_sticky_posts'       => true,
        'update_post_meta_cache'    => false,
        'no_found_rows'             => true,
        'meta_query'                => array(
            'relation' => 'AND',
            array(
                'key'       => 'done_r',
                'value'     => 'done',
                'compare'   => '=',
            ),
            array(
                'key'       => 'id_tournoi_r',
                'value'     => $id_top,
                'compare'   => '=',
            ),
            array(
                'key'       => 'uuid_user_r',
                'value'     => $uuid_user,
                'compare'   => '=',
            )
        )
    ));
    if($check_rank->have_posts()){
        $id_rank = wp_list_pluck($check_rank->posts, 'ID');
        $id_rank = $id_rank[0];
    }
    return $id_rank;
}