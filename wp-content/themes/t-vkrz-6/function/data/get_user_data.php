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

function get_vainkeur_id($uuiduser)
{

    $id_vainkeur    = false;

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

    if ($vainkeur_entry->have_posts()) {
        $id_vainkeur    = $vainkeur_entry->posts[0];
    }

    return $id_vainkeur;
}

function get_vainkeur_id_by_author()
{

    $user_id        = get_user_logged_id();

    $vainkeur_entry = new WP_Query(array(
        'post_type'              => 'vainkeur',
        'posts_per_page'         => '1',
        'fields'                 => 'ids',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'author'                 => $user_id
    ));

    if ($vainkeur_entry->have_posts()) {
        $id_vainkeur    = $vainkeur_entry->posts[0];
    }

    return $id_vainkeur;
}

function get_user_toplist($id_vainkeur)
{

    $user_toplist           = array();

    $vainkeur_list_ranking  = json_decode(get_field('liste_des_toplist_vkrz', $id_vainkeur));

    if ($vainkeur_list_ranking) {

        foreach ($vainkeur_list_ranking as $id_ranking) {

            $ranking          = array();
            $nb_votes         = get_field('nb_votes_r', $id_ranking);
            $id_top           = get_field('id_tournoi_r', $id_ranking);
            $typetop          = get_field('type_top_r', $id_ranking);
            $uuid_user        = get_field('uuid_user_r', $id_ranking);
            $ranking          = get_field('ranking_r', $id_ranking);
            $cat_id           = "";
            $nb_top           = "";

            if($ranking){
                $nb_top = $typetop == "top3" ? 3 : count($ranking);
            }

            if(get_field('done_r', $id_ranking) == "done"){
                $state = "done";
            }
            else{
                $state = "begin";
            }

            if (get_the_terms($id_top, 'categorie')) {
                foreach (get_the_terms($id_top, 'categorie') as $cat) {
                    $cat_id = $cat->term_id;
                }
            }

            array_push($user_toplist, array(
                "id_top"     => $id_top,
                "cat_t"      => $cat_id,
                "typetop"    => $typetop,
                "nb_top"     => $nb_top,
                "nb_votes"   => $nb_votes,
                "uuid_user"  => $uuid_user,
                "id_ranking" => $id_ranking,
                "state"      => $state
            ));

        }
    }

    $user_toplist = array_reverse($user_toplist);

    return $user_toplist;
}

function get_user_tops($id_vainkeur){

    $user_tops_begin_ids    = array();
    $user_tops_done_ids     = array();

    $vainkeur_list_tops_finish  = json_decode(get_field('liste_des_top_vkrz', $id_vainkeur));
    $vainkeur_list_tops_begin   = json_decode(get_field('liste_des_top_commences_vkrz', $id_vainkeur));

    if ($vainkeur_list_tops_finish) {

        foreach ($vainkeur_list_tops_finish as $id_top) {

            array_push($user_tops_done_ids, $id_top);

        }
    }

    if ($vainkeur_list_tops_begin) {

        foreach ($vainkeur_list_tops_begin as $id_top) {

            array_push($user_tops_begin_ids, $id_top);

        }
    }

    $user_tops_begin_ids = array_reverse($user_tops_begin_ids);
    $user_tops_done_ids  = array_reverse($user_tops_done_ids);

    return array(
        "list_user_tops_begin_ids"  => $user_tops_begin_ids,
        "list_user_tops_done_ids"   => $user_tops_done_ids
    );
}

function get_fantom($id_vainkeur = false){

    if($id_vainkeur){
        $result = array(
            'id_user'           => false,
            'pseudo'            => 'Lama2Lombre',
            'avatar'            => 'https://vainkeurz.com/wp-content/themes/t-vkrz-6/assets/images/vkrz/avatar-rose.png',
            'user_email'        => '',
            'user_role'         => 'subscriber',
            'level'             => '<span class="va va-z-20 va-egg"></span>',
            'level_number'      => 0,
            'next_level'        => '<span class="va va-z-20 va-hatching-chick"></span>',
            'uuid_vainkeur'     => get_field('uuid_user_vkrz', $id_vainkeur),
            'id_vainkeur'       => $id_vainkeur,
            'profil_url'        => '',
            'creator_url'       => '',
            'nb_vote_vkrz'          => get_field('nb_vote_vkrz', $id_vainkeur),
            'nb_top_vkrz'           => get_field('nb_top_vkrz', $id_vainkeur),
            'money_vkrz'            => get_field('money_vkrz', $id_vainkeur),
            'money_creator_vkrz'    => 0,
            'current_money_vkrz'    => get_field('money_disponible_vkrz', $id_vainkeur)
        );
    }
    else{
        $result = array(
            'id_user'           => false,
            'pseudo'            => 'Lama2Lombre',
            'avatar'            => 'https://vainkeurz.com/wp-content/themes/t-vkrz-6/assets/images/vkrz/avatar-rose.png',
            'user_email'        => '',
            'user_role'         => 'subscriber',
            'level'             => '<span class="va va-z-20 va-egg"></span>',
            'level_number'      => 0,
            'next_level'        => '<span class="va va-z-20 va-hatching-chick"></span>',
            'uuid_vainkeur'     => false,
            'id_vainkeur'       => false,
            'profil_url'        => '',
            'creator_url'       => '',
            'nb_vote_vkrz'          => 0,
            'nb_top_vkrz'           => 0,
            'money_vkrz'            => 0,
            'money_creator_vkrz'    => 0,
            'current_money_vkrz'    => 0
        );
    }

    return $result;
}

function get_user_infos($uuid_vainkeur, $size = "short"){

    $result = array();

    $user_search = new WP_User_Query(array(
        'number' => 1,
        'meta_query' => array(
            array(
                'key'     => 'uuiduser_user',
                'value'   => $uuid_vainkeur,
                'compare' => '=',
            )
        )
    ));

    $user_found = $user_search->get_results();

    if($user_found){
        foreach ($user_found as $user) {

            $user_id         = $user->ID;
            $user_info       = get_userdata($user_id);
            $user_pseudo     = $user_info->nickname;
            $user_email      = $user_info->user_email;
            $user_role       = $user_info->roles[0];

            $avatar_url      = get_avatar_url($user_id, ['size' => '80', 'force_default' => false]);

            $info_user_level = get_user_level($user_id);

            $id_vainkeur     = get_field('id_vainkeur_user', 'user_' . $user_id);

            $result = array(
                'id_user'           => $user_id,
                'pseudo'            => $user_pseudo,
                'avatar'            => $avatar_url,
                'user_email'        => $user_email,
                'user_role'         => $user_role,
                'level'             => $info_user_level['level_ico'],
                'level_number'      => $info_user_level['level_number'],
                'next_level'        => $info_user_level['next_level'],
                'uuid_vainkeur'     => $uuid_vainkeur,
                'id_vainkeur'       => $id_vainkeur,
                'profil_url'        => esc_url(get_author_posts_url($user_id)),
                'creator_url'       => get_the_permalink(218587) . '?creator_id=' . $user_id
            );
        }

        if ($size == "complete") {
            $nb_vote_vkrz           = get_field('nb_vote_vkrz', $id_vainkeur);
            $nb_top_vkrz            = get_field('nb_top_vkrz', $id_vainkeur);
            $money_vkrz             = get_field('money_vkrz', $id_vainkeur);
            $money_createur_vkrz    = get_field('money_creator_vkrz', $id_vainkeur);
            $money_parrain_vkrz     = get_field('money_parrainage_vkrz', $id_vainkeur);
            $current_money_vkrz     = get_field('money_disponible_vkrz', $id_vainkeur);
            $money_duplicated       = get_field('money_duplication_vkrz', $id_vainkeur);

            $result_more = array(
                'nb_vote_vkrz'          => $nb_vote_vkrz,
                'nb_top_vkrz'           => $nb_top_vkrz,
                'money_vkrz'            => $money_vkrz,
                'money_creator_vkrz'    => $money_createur_vkrz,
                'money_parrain_vkrz'    => $money_parrain_vkrz,
                'current_money_vkrz'    => $current_money_vkrz,
                'money_duplicated'      => $money_duplicated
            );

            $result = array_merge($result, $result_more);
        }
    }
    else{
        $result = array(
            'id_user'           => false,
            'pseudo'            => 'Lama2Lombre',
            'avatar'            => 'https://vainkeurz.com/wp-content/themes/t-vkrz-6/assets/images/vkrz/avatar-rose.png',
            'user_email'        => '',
            'user_role'         => 'anonyme',
            'level'             => '<span class="va va-z-20 va-egg"></span>',
            'level_number'      => 0,
            'next_level'        => '<span class="va va-z-20 va-hatching-chick"></span>',
            'uuid_vainkeur'     => false,
            'id_vainkeur'       => false,
            'profil_url'        => '#',
            'creator_url'       => '',
            'nb_vote_vkrz'          => 0,
            'nb_top_vkrz'           => 0,
            'money_vkrz'            => 0,
            'money_creator_vkrz'    => 0,
            'current_money_vkrz'    => 0
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
            $level          = '<span class="va va-z-20 va-level-icon va-egg"></span>';
            $level_number   = 0;
            $next_level     = '<span class="va va-z-20 va-level-icon va-hatching-chick"></span>';
            break;
        case 1 :
            $level          = '<span class="va va-z-20 va-level-icon va-hatching-chick"></span>';
            $level_number   = 1;
            $next_level     = '<span class="va va-z-20 va-level-icon va-chick"></span>';
            break;
        case 2 :
            $level          = '<span class="va va-z-20 va-level-icon va-chick"></span>';
            $level_number   = 2;
            $next_level     = '<span class="va va-z-20 va-level-icon va-rooster"></span>';
            break;
        case 3 :
            $level          = '<span class="va va-z-20 va-level-icon va-rooster"></span>';
            $level_number   = 3;
            $next_level     = '<span class="va va-z-20 va-level-icon va-turkey"></span>';
            break;
        case 4 :
            $level          = '<span class="va va-z-20 va-level-icon va-turkey"></span>';
            $level_number   = 4;
            $next_level     = '<span class="va va-z-20 va-level-icon va-swan"></span>';
            break;
        case 5 :
            $level          = '<span class="va va-z-20 va-level-icon va-swan"></span>';
            $level_number   = 5;
            $next_level     = '<span class="va va-z-20 va-level-icon va-flamingo"></span>';
            break;
        case 6 :
            $level          = '<span class="va va-z-20 va-level-icon va-flamingo"></span>';
            $level_number   = 6;
            $next_level     = '<span class="va va-z-20 va-level-icon va-peacock"></span>';
            break;
        case 7 :
            $level          = '<span class="va va-z-20 va-level-icon va-peacock"></span>';
            $level_number   = 7;
            $next_level     = '<span class="va va-z-20 va-level-icon va-dragon"></span>';
            break;
        case 8 :
            $level          = '<span class="va va-z-20 va-level-icon va-dragon"></span>';
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
        $top_finition  = 0;

        $nb_votes_all_t = $nb_votes_all_t + $nb_votes_t;
        $nb_ranks_all_t = $nb_ranks_all_t + $nb_ranks_t;
        $total_nb_completed_top = $total_nb_completed_top + $nb_completed_top;

        $top_finition = round($nb_completed_top * 100 / $nb_ranks_t);
        if($top_finition >= 100){
            $top_finition = 100;
        }

        array_push($list_creator_tops, array(
            "top_id"        => $id_top,
            "top_title"     => get_the_title($id_top),
            "nb_top"        => get_field('count_contenders_t', $id_top),
            "top_votes"     => $nb_votes_t,
            "top_ranks"     => $nb_ranks_t,
            "top_completed" => $nb_completed_top,
            "top_finition"  => $top_finition
        ));
    endwhile;

    $avatar_url      = get_avatar_url($creator_id, ['size' => '80', 'force_default' => false]);
    $info_user_level = get_user_level($creator_id);

    $finition_globale = round($total_nb_completed_top * 100 / $nb_ranks_all_t);
    if ($finition_globale >= 100) {
        $finition_globale = 100;
    }
    
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
        "finition_globale"  => $finition_globale
    );

}

function get_top_done_by_current_vainkeur($id_top, $id_vainkeur, $list_t_already_done = false){

    $already_done           = false;
    if(!isset($list_t_already_done)){
        $list_t_already_done    = json_decode(get_field('liste_des_top_vkrz', $id_vainkeur));
    }

    if (in_array($id_top, $list_t_already_done)) {
        $already_done = true;
    }

    return $already_done;
}
