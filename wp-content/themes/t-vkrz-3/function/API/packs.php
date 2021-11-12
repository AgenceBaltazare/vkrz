<?php
require_once('fct.php');


function get_single_ranking($data){

    $datas      = array();
    $id_ranking = $data['id_ranking'];
    $user_ranking = get_user_ranking($id_ranking);
    $total_rank  = array();

    $i=1;
    foreach ($user_ranking as $c) :

        array_push($total_rank, array(
            "place"     => $i,
            "contender" => get_the_title($c)
        ));
        
    $i++;
    endforeach;

    return $total_rank;
}
