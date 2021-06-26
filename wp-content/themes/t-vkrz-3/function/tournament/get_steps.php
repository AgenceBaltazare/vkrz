<?php
function get_steps($id_ranking){

    $typetop         = get_field('type_top_r', $id_ranking);
    $list_contenders = get_field('ranking_r', $id_ranking);
    $nb_contenders   = count($list_contenders);
    $counter         = 0;

    if($typetop == "top3"){

        $inf_1      = 0;
        $inf_2      = 0;
        $inf_3      = 0;
        $fact_inf_1 = 50 / ( $nb_contenders - 1);
        $fact_inf_2 = 25 / ( $nb_contenders - 2);
        $fact_inf_3 = 25 / ( $nb_contenders - 3);

        foreach($list_contenders as $contender) {

            if(count($contender['less_to']) >= 1){
                $inf_1++;
            }
            if(count($contender['less_to']) >= 2){
                $inf_2++;
            }
            if(count($contender['less_to']) >= 3){
                $inf_3++;
            }

        }

        $current_step = round(( $inf_1 * $fact_inf_1) + ( $inf_2 * $fact_inf_2) + ( $inf_3 * $fact_inf_3));

    }
    else{

        foreach($list_contenders as $contender) {

            $counter = $counter + count($contender['more_to']) + count($contender['less_to']);

        }
        $current_step = round($counter / (($nb_contenders - 1) * $nb_contenders) * 100);


    }

    return $current_step;

}
?>