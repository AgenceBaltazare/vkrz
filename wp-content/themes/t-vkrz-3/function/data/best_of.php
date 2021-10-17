<?php

function best_tops($rankings){
    $latest_tops = array();

    if ($rankings->have_posts()) {
        foreach ($rankings->posts as $ranking_id) {
            array_push($latest_tops, get_field('id_tournoi_r', $ranking_id));
        }
    }
    $best_tops = array_count_values($latest_tops);
    arsort($best_tops, SORT_NUMERIC);

    return $best_tops;
}