<?php
function all_user_votes_in_top($id_ranking) {
    $all_user_votes = 0;
    $all_user_votes = get_field('nb_votes_r', $id_ranking);
    if(!$all_user_votes){
        $all_user_votes = 0;
    }

    return $all_user_votes;
}