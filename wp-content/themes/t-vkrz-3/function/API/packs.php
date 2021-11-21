<?php
require_once('fct.php');

function get_single_ranking($data){

    $id_ranking   = $data['id_ranking'];
    $user_ranking = get_user_ranking($id_ranking);
    $total_rank   = "";

    foreach ($user_ranking as $c) :

        $total_rank .= get_the_title($c)." ";
    
    endforeach;

    return $total_rank;
}
