<?php

function count_users_by_level($level = NULL){
    if (is_null($level) && !is_int($level)) {
        return NULL;
    }

    $user_query = new WP_User_Query(array(
        "number" => 100,
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

    $users      = array();
    $list_users = array();

    if ($user_query->get_total() > 0) {
        foreach($user_query->get_results() as $user){

            $user_id    = $user->ID;
            $total_vote = 0;
            $total_top  = 0;

            if(!in_array($user_id, $list_users)){
                $id_vainkeur    = get_field('id_vainkeur_user', 'user_' . $user_id);
                $total_vote     = get_field("nb_vote_vkrz", $id_vainkeur);
                $total_top      = get_field("nb_top_vkrz", $id_vainkeur);

                $users[] = array(
                    "id"         => $user->ID,
                    "registered" => $user->user_registered,
                    "pseudo"     => $user->user_nicename,
                    "id_vainkeur" => $id_vainkeur,
                    "total_vote" => $total_vote,
                    "total_top"  => $total_top,
                );
            }

            array_push($list_users, $user_id);

        }
    }

    if ($order == "ASC" && $order_by) {
        usort($users, function($a, $b) use($order_by) {
            return $a[$order_by] <=> $b[$order_by];
        });
    }

    if ($order == "DESC" && $order_by) {
        usort($users, function($a, $b) use($order_by) {
            return $b[$order_by] <=> $a[$order_by];
        });
    }

    return $users;
}
