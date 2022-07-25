<?php

function count_users_by_level($level = NULL){
    if (is_null($level) && !is_int($level)) {
        return NULL;
    }

    $user_query = new WP_User_Query(array(
        "number" => -1,
        "meta_query" => array(
            array(
                "key"     => "level_user",
                "value"   => $level,
                "compare" => "=",
            )
        )
    ));
    $users = $user_query->get_total();

    return $users;
}

function get_users_by_level($level = NULL, $order_by = "login", $order = "ASC"){
    if (is_null($level) && !is_int($level)) {
        return NULL;
    }

    $user_query = new WP_User_Query(array(
        "number" => -1,
        "meta_query" => array(
            array(
                "key"     => "level_user",
                "value"   => $level,
                "compare" => "=",
            )
        ),
    ));

    $users = array();
    if ($user_query->get_total() > 0) {
        foreach($user_query->get_results() as $user){
            $total_vote = 0;
            $total_top =  0;

            $vainkeur = new WP_Query(array(
                "post_type"              => "vainkeur",
                "posts_per_page"         => "1",
                "fields"                 => "ids",
                "post_status"            => "publish",
                "ignore_sticky_posts"    => true,
                "update_post_meta_cache" => false,
                "no_found_rows"          => false,
                "author__in"             => $user->ID,
            ));

            if($vainkeur->have_posts()){
                $vainkeur_id = $vainkeur->posts[0];
                $total_vote = get_field("nb_vote_vkrz", $vainkeur_id);
                $total_top = get_field("nb_top_vkrz", $vainkeur_id);
            }

            $users[] = array(
                "id" => $user->ID,
                "registered" => $user->user_registered,
                "pseudo" => $user->user_nicename,
                "total_vote" => $total_vote,
                "total_top" => $total_top,
            );
        }
    }

    if ($order == "ASC" && $order_by != "login") {
        usort($users, function($a, $b) use($order_by) {
            return $a[$order_by] <=> $b[$order_by];
        });
    }

    if ($order == "DESC" && $order_by != "login") {
        usort($users, function($a, $b) use($order_by) {
            return $b[$order_by] <=> $a[$order_by];
        });
    }


    return $users;
}
