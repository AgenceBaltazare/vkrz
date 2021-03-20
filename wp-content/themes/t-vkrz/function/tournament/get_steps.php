<?php
function get_steps($id_ranking){

    /*
     * à chaque tour ((compter le nombre de inf et de sup de chaque participant, faire le total) diviser le tout par (le nombre de participant - 1) x (nombre de participant)) x100
     */

    $list_contenders = get_field('ranking_r', $id_ranking);
    $nb_contenders   = count($list_contenders);
    $counter         = 0;

    foreach($list_contenders as $contender) {

        $counter = $counter + count($contender['more_to']) + count($contender['less_to']);

    }
    $current_step = round($counter / (($nb_contenders - 1) * $nb_contenders) * 100);

    return $current_step;

}
?>