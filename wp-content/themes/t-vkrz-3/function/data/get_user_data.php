<?php

function get_user_full_data($uuiduser){

    if(!$uuiduser){
        if(isset($_COOKIE["vainkeurz_user_id"])){
            $uuiduser       = $_COOKIE["vainkeurz_user_id"];
        }
        else{
            $uuiduser       = "nouuiduser";
        }
    }

    $count_user_votes       = 0;
    $user_ranking_done      = array();
    $user_ranking_begin     = array();
    $user_ranking_all       = array();
    $result                 = array();
    $user_tops_done_ids     = array();

    // Get user ranking
    $user_all_ranking = new WP_Query(array(
        'post_type'              => 'classement',
        'posts_per_page'         => '-1',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'meta_query'             =>
            array(
                array(
                    'key' => 'uuid_user_r',
                    'value' => $uuiduser,
                    'compare' => '=',
                )
            )
        )
    );
    while ($user_all_ranking->have_posts()) : $user_all_ranking->the_post();

        $count_user_votes = $count_user_votes + get_field('nb_votes_r');

        if(get_field('done_r') == "done"){
            $done = true;
        }
        else{
            $done = false;
        }

        if(get_field('done_r') == "done"){
            array_push($user_ranking_done, array(
                "id_tournoi" => get_field('id_tournoi_r'),
                "nb_top"     => count(get_field('ranking_r')),
                "done"       => $done,
                "nb_votes"   => get_field('nb_votes_r'),
                "id_ranking" => get_the_ID(),
            ));
            array_push($user_tops_done_ids, get_field('id_tournoi_r'));
        }
        else{
            if(get_field('nb_votes_r') >= 1) {
                array_push($user_ranking_begin, array(
                    "id_tournoi" => get_field('id_tournoi_r'),
                    "nb_top"     => count(get_field('ranking_r')),
                    "done"       => $done,
                    "nb_votes"   => get_field('nb_votes_r'),
                    "id_ranking" => get_the_ID(),
                ));
            }
        }
        if(get_field('nb_votes_r') >= 1) {
            array_push($user_ranking_all, array(
                "id_tournoi" => get_field('id_tournoi_r'),
                "nb_top"     => count(get_field('ranking_r')),
                "done"       => $done,
                "nb_votes"   => get_field('nb_votes_r'),
                "id_ranking" => get_the_ID(),
            ));
        }

    endwhile;

    wp_reset_postdata();
    wp_reset_query();

    array_push($result, array(
        "nb_user_votes"             => $count_user_votes,
        "list_user_ranking_done"    => $user_ranking_done,
        "list_user_ranking_begin"   => $user_ranking_begin,
        "list_user_ranking_all"     => $user_ranking_all,
        "user_tops_done_ids"        => $user_tops_done_ids
    ));

    return $result;

}

function get_user_percent($uuiduser, $id_tournament){

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
            $current_user_top3       = get_user_ranking($current_user_id_ranking);
        }

        if(get_field('uuid_user_r') != $uuiduser) {
            array_push($list_ranking_of_t, array(
                "id_ranking" => get_the_id(),
                "uuid_user" => get_field('uuid_user_r')
            ));
        }

    endwhile;

    foreach($list_ranking_of_t as $rank){

        if(get_user_ranking($rank['id_ranking']) == $current_user_top3){
            $count_same_ranking++;
        }

    }
    $nb_tops = $all_ranking_of_t->post_count;

    $percent = round($count_same_ranking * 100 / $nb_tops);

    return $percent;

}

function get_user_level($uuiduser, $user_id = false, $nb_user_votes = false){

    if(!$nb_user_votes){

        $user_full_data     = get_user_full_data($uuiduser);
        $nb_user_votes      = $user_full_data[0]['nb_user_votes'];

    }

    $niv_1 = 50;
    $niv_2 = 500;
    $niv_3 = 2000;
    $niv_4 = 5000;
    $niv_5 = 15000;
    $niv_6 = 30000;
    $niv_7 = 70000;
    $niv_8 = 100000;

    if(is_user_logged_in()){
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

    }
    else{

        $level = "🥚";
        $result = array(
            "level_ico"       => $level,
            "level_number"    => "",
            "votes_restant"   => "",
            "next_level"      => ""
        );

    }

    return $result;

}