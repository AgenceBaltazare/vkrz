<?php

/**
 * Get best vainkeur by top or vote
 *
 * @param   {string}    type        - "top" | "vote" (default "top")
 * @param   {number}    period      - in days (default NULL)
 * @param   {number}    limit       - number of return vainkeur (default 1)
 *
 * return array of [vainkeur_id, author_id, uuid, total_vote, total_top]
 */
function get_best_vainkeur($type = "top", $period = NULL, $limit = 1) {

    if($type == "top"){
        $meta_key = "nb_top_vkrz";
    } elseif ($type == "top") {
        $meta_key = "nb_vote_vkrz";
    } elseif ($type == "money") {
        $meta_key = "money_vkrz";
    }
    $return = array();

    if (is_null($period)) {
        $vainkeurs = new WP_Query(array(
            "post_type"              => "vainkeur",
            "posts_per_page"         => $limit,
            'fields'                 => 'ids',
            "post_status"            => "publish",
            "update_post_meta_cache" => false,
            "no_found_rows"          => false,
            "meta_key"               => $meta_key,
            "orderby"                => "meta_value_num",
            "order"                  => "DESC",
            "author__not_in"         => array(0, 1), // To exclude vainkeur not registered (with no author)
        ));

        if ($vainkeurs->have_posts()) {
            foreach ($vainkeurs->posts as $vainkeur_id) {
                $return[] = array(
                    "vainkeur_id" => $vainkeur_id,
                    "author_id" => get_post_field("post_author", $vainkeur_id),
                    "uuid" => get_field("uuid_user_vkrz", $vainkeur_id),
                    "xp" => get_field("money_vkrz", $vainkeur_id),
                    "total_vote" => get_field("nb_vote_vkrz", $vainkeur_id),
                    "total_top" => get_field("nb_top_vkrz", $vainkeur_id)
                );
            }
        }
    } 
    else {
        $tops = new WP_Query(array(
            "post_type"              => "classement",
            "posts_per_page"         => -1,
            "fields"                 => "ids",
            "post_status"            => "publish",
            "update_post_meta_cache" => false,
            "no_found_rows"          => false,
            "author__not_in"         => array(0, 1, 58), // To exclude vainkeur not registered (with no author)
            "date_query"             => array(
                array(
                    "after" => $period." days ago"
                )
            )
        ));

        if ($tops->have_posts()) {

            $nb_vote_period = 0;
            $nb_top_period  = 0;

            foreach ($tops->posts as $top_id) {
                $author_id = get_post_field("post_author", $top_id);

                $key = array_search($author_id, array_column($return, 'author_id'));

                $nb_vote_period = $nb_vote_period + intval(get_field("nb_votes_r", $top_id));
                $nb_top_period  = $nb_top_period++;

                if ($key !== false || $key === 0) {
                    $return[$key]["total_vote"] = $return[$key]["total_vote"] + intval(get_field("nb_votes_r", $top_id));
                    get_field("done_r", $top_id) == "done" ? $return[$key]["total_top"]++ : $return[$key]["total_top"];
                } else {
                    $vainkeur = new WP_Query(array(
                        "post_type"              => "vainkeur",
                        "posts_per_page"         => "1",
                        "fields"                 => "ids",
                        "post_status"            => "publish",
                        "ignore_sticky_posts"    => true,
                        "update_post_meta_cache" => false,
                        "no_found_rows"          => false,
                        "author"                 => $author_id,
                    ));
                    $vainkeur_id = $vainkeur->posts[0];

                    $return[] = array(
                        "vainkeur_id"   => $vainkeur_id,
                        "author_id"     => $author_id,
                        "vote_period"   => $nb_vote_period,
                        "top_period"    => $nb_top_period,
                        "uuid"          => get_field("uuid_user_r", $top_id),
                        "money"         => get_field("money_vkrz", $vainkeur_id),
                        "total_vote"    => intval(get_field("nb_votes_r", $top_id)),
                        "total_top"     => get_field("done_r", $top_id) == "done" ? 1 : 0
                    );
                }
            }
        }

        if ($type == "top") {
            usort($return, function($a, $b) {
                return $b["total_top"] <=> $a["total_top"];
            });
        }

        if ($type == "vote") {
            usort($return, function($a, $b) {
                return $b["total_vote"] <=> $a["total_vote"];
            });
        }

        $return = array_slice($return, 0, $limit);
    }

    return $return;
}
