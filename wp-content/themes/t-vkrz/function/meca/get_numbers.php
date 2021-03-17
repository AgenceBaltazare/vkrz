<?php
function get_user_nb_vote_r($list_contenders){

    $sum_vote = 0;
    foreach($list_contenders as $item){
        $sum_vote = $sum_vote + $item['vote'];
    }
    $nb_votes = $sum_vote / 2;

    return $nb_votes;

}