<?php
require_once('fct.php');


function get_single_ranking($data){

    $list_ranking      = "";
    $id_ranking = $data['id_ranking'];
    $user_ranking = get_user_ranking($id_ranking);
    $total_rank  = array();

    $i=1;
    foreach ($user_ranking as $c) :

        $list_ranking .= get_the_title($c) . " ";

    $i++;
    endforeach;

    array_push($total_rank, array(
        "classement" => $list_ranking,
    ));
        
    return $total_rank;
}
