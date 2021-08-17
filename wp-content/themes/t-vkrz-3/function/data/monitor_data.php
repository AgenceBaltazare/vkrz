<?php
function get_monitor_data(){

    $total_vkrz_votes = get_field('nb_total_votes', 'options');
    $total_vkrz_tops  = get_field('nb_total_tops', 'options');


    return die(json_encode( array(
        'total_vkrz_votes'  => $total_vkrz_votes,
        'total_vkrz_tops'   => $total_vkrz_tops,
    )));

}