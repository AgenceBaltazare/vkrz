<?php

function best_tops($rankings){
    $latest_tops = array();

    if ($rankings->have_posts()) {
        foreach ($rankings->posts as $ranking_id) {
            array_push($latest_tops, get_field("id_tournoi_r", $ranking_id));
        }
    }
    $best_tops = array_count_values($latest_tops);
    arsort($best_tops, SORT_NUMERIC);

    return $best_tops;
}

function best_creators(){
    $rankings_by_top = array();
    $best_creators = array();

    $rankings = new WP_Query(array(
        "post_type" => "classement",
        "posts_per_page" => -1,
        "fields" => "ids",
        "ignore_sticky_posts" => true,
        "update_post_meta_cache" => false,
        "no_found_rows" => true,
        "meta_query" => array(
                array(
                    "key"       => "nb_votes_r",
                    "value"     => 0,
                    "compare"   => ">",
                )
            )
        )
    );

    if ($rankings->have_posts()) {
        foreach ($rankings->posts as $ranking_id) {
            $top_id = get_field("id_tournoi_r", $ranking_id);

            if (array_key_exists($top_id, $rankings_by_top)) {
                $rankings_by_top[$top_id]["total_vote"] = $rankings_by_top[$top_id]["total_vote"] + get_field("nb_votes_r", $ranking_id);
                if(get_field('done_r', $ranking_id) == "done") { $rankings_by_top[$top_id]["total_completed_top"]++; }

            } else {
                $rankings_by_top[$top_id] = array(
                    "total_vote" => get_field("nb_votes_r", $ranking_id),
                    "total_completed_top" => get_field('done_r', $ranking_id) == "done" ? intval(1) : intval(0)
                );
            }
        }
    }

    $users = new WP_User_Query(
        array(
            "fields" => "ID",
            "number" => -1,
            "role__in" => array("author", "administrator")
        )
    );
    $users = $users->get_results();

    foreach ($users as $user_id) {
        $user_info = get_userdata($user_id);
        $count_vote = 0;
        $count_completed_top = 0;

        $tops = new WP_Query(array(
            'post_type' => 'tournoi',
            'posts_per_page' => -1,
            "fields" => "ids",
            'ignore_sticky_posts' => true,
            'update_post_meta_cache' => false,
            'no_found_rows' => false,
            'author' => $user_id,
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field'    => 'slug',
                    'terms'    => array('onboarding', 'private', 'whitelabel'),
                    'operator' => 'NOT IN',
                )
            ),
        ));

        if ($tops->have_posts()) {
            foreach ($tops->posts as $top_id) {
                if (array_key_exists($top_id, $rankings_by_top)) {
                    $count_vote = $rankings_by_top[$top_id]["total_vote"] + $count_vote;
                    $count_completed_top = $rankings_by_top[$top_id]["total_completed_top"] + $count_completed_top;
                }
            }
        }

        $best_creators[] = array(
            "user_id" => $user_id,
            "user_pseudo" => $user_info->nickname,
            "user_avatar" => get_avatar_url($user_id, ["size" => "80", "force_default" => false]),
            "user_level_icon" => get_user_level($user_id)["level_ico"],
            "user_role" => $user_info->roles[0],
            "top_created" => count_user_posts($user_id , 'tournoi'), 
            "total_vote" => $count_vote,
            "total_completed_top" => $count_completed_top
        );
    }

    usort($best_creators, function ($a, $b) {
        return $b["total_completed_top"] <=> $a["total_completed_top"];
    });

    return $best_creators;
}