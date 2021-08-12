<?php

/**
 * Get user full data
 *
 * @param   {String}    user_id     - uuiduser or author_id
 * @param   {String}    type        - uuiduser by default or author
 * @returns {Array}
 */
function get_user_full_data(
    $user_id,
    $type = "uuiduser"
){

    if (!$user_id) {
        if (isset($_COOKIE["vainkeurz_user_id"])) {
            $user_id = $_COOKIE["vainkeurz_user_id"];
        } else {
            $user_id = "nouuiduser";
        }
    }

    $count_user_votes       = 0;
    $user_ranking_done      = array();
    $user_ranking_begin     = array();
    $user_ranking_all       = array();
    $user_tops_done_ids     = array();

    $args_meta_query = $type == "author" ? array() : array(array(
                                                           'key' => 'uuid_user_r',
                                                           'value' => $user_id,
                                                           'compare' => '='));
   $args_author__in = $type == "author" ? array($user_id) : array();

    // Get user ranking
    $user_all_ranking = new WP_Query(array(
        'post_type'              => 'classement',
        'posts_per_page'         => '1000',
        'fields'                 => 'ids',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'meta_query'             => $args_meta_query,
        'author__in'             => $args_author__in,
    ));

    if ($user_all_ranking->have_posts()) {
        foreach ($user_all_ranking->posts as $classement) {
            $nb_votes         = get_field('nb_votes_r', $classement);
            $id_tournament    = get_field('id_tournoi_r', $classement);
            $typetop          = get_field('type_top_r', $classement);
            $uuid_user        = get_field('uuid_user_r', $classement);

            $count_user_votes = $count_user_votes + $nb_votes;

            $done = get_field('done_r', $classement) == "done" ? true : false;
            // /!\ ranking_r is a textarea, why use count for a string ?
            $nb_top = $typetop == "top3" ? 3 : count(get_field('ranking_r', $classement));

            if (get_the_terms($id_tournament, 'categorie')) {
                foreach (get_the_terms($id_tournament, 'categorie') as $cat) {
                    $cat_id = $cat->term_id;
                }
            }

            if ($done) {
                array_push($user_ranking_done, array(
                    "id_tournoi" => $id_tournament,
                    "cat_t"      => $cat_id,
                    "typetop"    => $typetop,
                    "nb_top"     => $nb_top,
                    "done"       => $done,
                    "nb_votes"   => $nb_votes,
                    "uuid_user"  => $uuid_user,
                    "id_ranking" => $classement,
                ));
                array_push($user_tops_done_ids, $id_tournament);
            } else {
                if($nb_votes >= 1) {
                    array_push($user_ranking_begin, array(
                        "id_tournoi" => $id_tournament,
                        "typetop"    => $typetop,
                        "nb_top"     => $nb_top,
                        "done"       => $done,
                        "nb_votes"   => $nb_votes,
                        "uuid_user"  => $uuid_user,
                        "id_ranking" => $classement,
                    ));
                }
            }

            if($nb_votes >= 1) {
                array_push($user_ranking_all, array(
                    "id_tournoi" => $id_tournament,
                    "typetop"    => $typetop,
                    "nb_top"     => $nb_top,
                    "done"       => $done,
                    "nb_votes"   => $nb_votes,
                    "uuid_user"  => $uuid_user,
                    "id_ranking" => $classement,
                ));
            }
        }
    }

    return array(
        array(
            "nb_user_votes"             => $count_user_votes,
            "list_user_ranking_done"    => $user_ranking_done,
            "list_user_ranking_begin"   => $user_ranking_begin,
            "list_user_ranking_all"     => $user_ranking_all,
            "user_tops_done_ids"        => $user_tops_done_ids
        )
    );
}

function get_user_percent($uuiduser, $id_tournament){

    $result                 = array();
    $list_ranking_of_t      = array();
    $count_same_ranking     = 0;
    $all_ranking_of_t       = new WP_Query(array(
        'post_type' => 'classement',
        'posts_per_page' => '-1',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'nb_votes_r',
                'value' => 0,
                'compare' => '>',
            ),
            array(
                'key' => 'id_tournoi_r',
                'value' => $id_tournament,
                'compare' => '=',
            )
        )
    ));
    while ($all_ranking_of_t->have_posts()) : $all_ranking_of_t->the_post();

        if(get_field('uuid_user_r') == $uuiduser){
            $current_user_id_ranking = get_the_id();
            $current_user_top3       = get_user_ranking($current_user_id_ranking, 3);
        }

        if(get_field('uuid_user_r') != $uuiduser) {
            array_push($list_ranking_of_t, array(
                "id_ranking" => get_the_id(),
                "uuid_user"  => get_field('uuid_user_r')
            ));
        }

    endwhile;

    foreach($list_ranking_of_t as $rank){

        if(get_user_ranking($rank['id_ranking'], 3) == $current_user_top3){
            $count_same_ranking++;
        }

    }

    $nb_tops = $all_ranking_of_t->post_count;

    $percent = round($count_same_ranking * 100 / $nb_tops);

    $all_ranking_of_t->reset_postdata();

    wp_reset_query();

    array_push($result, array(
        "percent" => $percent,
        "nb_similar" => $count_same_ranking + 1,
    ));

    return $result;
}

function get_vkrz_users($limit = false){

    $result = array();

    $user_query = new WP_User_Query(array('number' => -1));
    $users_list = $user_query->get_results();

    foreach($users_list as $user){

        $user_ID    = $user->ID;
        $user_info  = get_userdata($user_ID);
        $user_role  = $user_info->roles[0];

        $avatar_url = get_avatar_url($user_ID, ['size' => '80']);
        if(!$avatar_url){
            $avatar_url = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
        }

        $uuidchampion    = get_field('uuiduser_user', 'user_'.$user_ID);
        $user_full_data  = get_user_full_data($uuidchampion);
        $nb_user_votes   = $user_full_data[0]['nb_user_votes'];
        $nb_user_tops    = $user_full_data[0]['list_user_ranking_done'];
        $info_user_level = get_user_level(false, false, $nb_user_votes);
        $user_level      = $info_user_level['level_ico'];

        array_push($result, array(
            "user_id"       => $user_ID,
            "user_role"     => $user_role,
            "user_name"     => $user_info->nickname,
            "user_level"    => $user_level,
            "user_votes"    => $nb_user_votes,
            "user_tops"     => count($nb_user_tops),
            "user_avatar"   => $avatar_url
        ));

    }
    array_multisort(array_column($result, "user_votes"), SORT_DESC, $result);

    if($limit){
        $result = array_slice($result, 0, $limit);
    }

    return $result;

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

        $result    = $user->ID;

    }

    return $result;

}

function get_user_level($uuiduser = false, $user_id = false, $nb_user_votes = false){

    if(!$nb_user_votes){

        $user_full_data     = $user_id ? get_user_full_data($user_id, "author") : get_user_full_data($uuiduser);
        $nb_user_votes      = $user_full_data[0]['nb_user_votes'];

    }

    $niv_1 = 50;
    $niv_2 = 500;
    $niv_3 = 2000;
    $niv_4 = 5000;
    $niv_5 = 35000;
    $niv_6 = 100000;
    $niv_7 = 450000;
    $niv_8 = 1000000;

    if($nb_user_votes < $niv_1){

        $level          = "🥚";
        $level_number   = 0;
        $next_level     = "🐣";
        $votes_restant  = $niv_1 - $nb_user_votes;
        update_field('level_user', 0, 'user_' . $user_id);

    }
    elseif($niv_1 <= $nb_user_votes && $nb_user_votes < $niv_2){

        $level          = "🐣";
        $level_number   = 1;
        $next_level     = "🐥";
        $votes_restant  = $niv_2 - $nb_user_votes;
        update_field('level_user', 1, 'user_' . $user_id);

    }
    elseif($niv_2 <= $nb_user_votes && $nb_user_votes < $niv_3){

        $level          = "🐥";
        $level_number   = 2;
        $next_level     = "🐓";
        $votes_restant  = $niv_3 - $nb_user_votes;
        update_field('level_user', 2, 'user_' . $user_id);

    }
    elseif($niv_3 <= $nb_user_votes && $nb_user_votes < $niv_4){

        $level          = "🐓";
        $level_number   = 3;
        $next_level     = "🦃";
        $votes_restant  = $niv_4 - $nb_user_votes;
        update_field('level_user', 3, 'user_' . $user_id);

    }
    elseif($niv_4 <= $nb_user_votes && $nb_user_votes < $niv_5){

        $level          = "🦃";
        $level_number   = 4;
        $next_level     = "🦢";
        $votes_restant  = $niv_5 - $nb_user_votes;
        update_field('level_user', 4, 'user_' . $user_id);

    }
    elseif($niv_5 <= $nb_user_votes && $nb_user_votes < $niv_6){

        $level          = "🦢";
        $level_number   = 5;
        $next_level     = "🦩";
        $votes_restant  = $niv_6 - $nb_user_votes;
        update_field('level_user', 5, 'user_' . $user_id);

    }
    elseif($niv_6 <= $nb_user_votes && $nb_user_votes < $niv_7){


        $level          = "🦩";
        $level_number   = 6;
        $next_level     = "🦚";
        $votes_restant  = $niv_7 - $nb_user_votes;
        update_field('level_user', 6, 'user_' . $user_id);

    }
    elseif($niv_7 <= $nb_user_votes && $nb_user_votes < $niv_8){

        $level          = "🦚";
        $level_number   = 7;
        $next_level     = "🐉";
        $votes_restant  = $niv_8 - $nb_user_votes;
        update_field('level_user', 7, 'user_' . $user_id);

    }
    elseif($nb_user_votes >= $niv_8){

        $level = "🐉";
        $level_number = 8;
        $next_level   = "🐉";
        $votes_restant = 0;
        update_field('level_user', 8, 'user_' . $user_id);

    }

    if($votes_restant < 0){
        $votes_restant = 0;
    }

    $result = array(
        "level_ico"       => $level,
        "level_number"    => $level_number,
        "votes_restant"   => $votes_restant,
        "next_level"      => $next_level
    );

    return $result;

}

function get_creator_data($creator_id = false, $id_tournament = false){

    $result             = array();
    $list_creator_tops  = array();

    if(!$creator_id){
        $creator_id = get_post_field('post_author', $id_tournament);
    }
    $creator_data   = get_user_by('ID', $creator_id);

    $list_tops = new WP_Query(array('post_type' => 'tournoi', 'orderby' => 'date', 'author' => $creator_id, 'posts_per_page' => '-1'));
    while ($list_tops->have_posts()) : $list_tops->the_post();
        array_push($list_creator_tops, get_the_ID());
    endwhile;

    array_push($result, array(
        "creator_id"        => $creator_id,
        "creator_link"      => get_author_posts_url($creator_id),
        "creator_name"      => $creator_data->nickname,
        "creator_nb_tops"   => count($list_creator_tops),
        "creator_tops"      => $list_creator_tops,
        "creator_uuid"      => get_field('uuiduser_user', 'user_'.$creator_id)
    ));

    return $result;

}

function get_creators_ids(){

    $result = array();

    $list_tops = new WP_Query(array(
        'post_type' => 'tournoi',
        'orderby' => 'date',
        'posts_per_page' => '-1'
    ));
    while ($list_tops->have_posts()) : $list_tops->the_post();
        $creator_id    = get_post_field('post_author', get_the_ID());
        array_push($result, $creator_id);
    endwhile;

    return $result;
}

function get_creator_t($creator_id){

    $result             = array();
    $list_creator_tops  = array();
    $creator_data       = get_user_by('ID', $creator_id);
    $nb_votes_all_t     = 0;
    $nb_ranks_all_t     = 0;
    $total_money        = array();

    $list_tops = new WP_Query(array(
        'post_type'              => 'tournoi',
        'orderby'                => 'date',
        'posts_per_page'         => 500,
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'author'                 => $creator_id,
    ));
    while ($list_tops->have_posts()) : $list_tops->the_post();

        $id_tournament = get_the_ID();

        $data_t        = get_tournoi_data($id_tournament);
        $nb_votes_t    = $data_t[0]['nb_votes'];
        $nb_ranks_t    = $data_t[0]['nb_tops'];

        $nb_votes_all_t = $nb_votes_all_t + $nb_votes_t;
        $nb_ranks_all_t = $nb_ranks_all_t + $nb_ranks_t;

        $money_top = get_paid($nb_votes_t);
        array_push($total_money, $money_top);

        array_push($list_creator_tops, array(
            "top_id"        => $id_tournament,
            "top_title"     => get_the_title($id_tournament),
            "nb_top"        => get_numbers_of_contenders($id_tournament),
            "top_votes"     => $nb_votes_t,
            "top_ranks"     => $nb_ranks_t,
            "top_money"     => $money_top
        ));
    endwhile;

    array_push($result, array(
        "creator_id"        => $creator_id,
        "creator_link"      => get_author_posts_url($creator_id),
        "creator_name"      => $creator_data->nickname,
        "creator_nb_tops"   => count($list_creator_tops),
        "creator_tops"      => $list_creator_tops,
        "creator_all_v"     => $nb_votes_all_t,
        "creator_all_t"     => $nb_ranks_all_t,
        "creator_money"     => array_sum($total_money),
        "creator_uuid"      => get_field('uuiduser_user', 'user_'.$creator_id)
    ));

    return $result;

}