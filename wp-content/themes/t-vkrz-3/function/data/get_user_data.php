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

    array_push($result, array(
        "nb_user_votes"             => $count_user_votes,
        "list_user_ranking_done"    => $user_ranking_done,
        "list_user_ranking_begin"   => $user_ranking_begin,
        "list_user_ranking_all"     => $user_ranking_all,
        "user_tops_done_ids"        => $user_tops_done_ids
    ));

    return $result;

}