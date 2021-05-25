<?php

function get_contenders_top_3_2($id_ranking){

    $list_inf        = array();
    $list_contenders = get_field('ranking_r', $id_ranking);

    foreach($list_contenders as $key => $contender) {

        if(empty($contender['less_to'])){

            array_push($list_inf, $contender['id_wp']);

        }

    }

    return $list_inf;

}
function get_contenders_top_3_3($id_ranking){

    $list_inf        = array();
    $list_contenders = get_field('ranking_r', $id_ranking);

    foreach($list_contenders as $key => $contender) {

        if(count($contender['less_to']) == 1){

            array_push($list_inf, $contender['id_wp']);

        }

    }

    return $list_inf;

}
function get_contenders_top_3_4($id_ranking){

    $list_inf        = array();
    $list_contenders = get_field('ranking_r', $id_ranking);

    foreach($list_contenders as $key => $contender) {

        if(count($contender['less_to']) == 2){

            array_push($list_inf, $contender['id_wp']);

        }

    }

    return $list_inf;

}

function check_battle_2($id_ranking, $list, $timeline, $timeline_main){

    $list_contenders = get_field('ranking_r', $id_ranking);
    $list_inf_of_c1  = array();
    $list_inf_of_c2  = array();
    $list_sup_of_c1  = array();
    $list_sup_of_c2  = array();
    $battle          = false;
    $nb_list         = count($list);
    $next_duel       = array();

    for($m=0; $m<=$nb_list; $m++){

        if($battle == false){

            foreach($list_contenders as $key => $contender) {

                if($contender['id_wp'] == $list[$timeline - 1]){
                    $key_c1             = $key;
                    $key_c1_wp          = $contender['id_wp'];
                    $list_inf_of_c1     = $contender['more_to'];
                    $list_sup_of_c1     = $contender['less_to'];
                }

                if($contender['id_wp'] == $list[$timeline]){
                    $key_c2             = $key;
                    $key_c2_wp          = $contender['id_wp'];
                    $list_inf_of_c2     = $contender['more_to'];
                    $list_sup_of_c2     = $contender['less_to'];
                }

            }

            $c1_less_more = array_merge($list_inf_of_c1, $list_sup_of_c1);
            $c2_less_more = array_merge($list_inf_of_c2, $list_sup_of_c2);

            if(in_array($key_c1, $c2_less_more) || in_array($key_c2, $c1_less_more) || ($key_c1 == $key_c2)){

                $battle = false;

                $timeline      = $timeline + 1;
                update_field('timeline_'.$timeline_main, $timeline, $id_ranking);

            }
            else{

                $battle        = true;
                $timeline      = get_field('timeline_'.$timeline_main, $id_ranking);
                array_push($next_duel, $key_c1_wp);
                array_push($next_duel, $key_c2_wp);

            }

        }
        else{

            break;

        }

    }


    return $next_duel;

}

function check_battle_4($id_ranking, $list, $timeline, $timeline_main, $spaire){

    $list_contenders = get_field('ranking_r', $id_ranking);
    $list_inf_of_c1  = array();
    $list_inf_of_c2  = array();
    $list_sup_of_c1  = array();
    $list_sup_of_c2  = array();
    $battle          = false;
    $nb_list         = count($list);
    $next_duel       = array();

    for($m=0; $m<=$nb_list; $m++){

        if($battle == false){

            foreach($list_contenders as $key => $contender) {

                if($contender['id_wp'] == $list[$nb_list - ($spaire - ($timeline - 1))]){
                    $key_c1             = $key;
                    $key_c1_wp          = $contender['id_wp'];
                    $list_inf_of_c1     = $contender['more_to'];
                    $list_sup_of_c1     = $contender['less_to'];
                }
                if($contender['id_wp'] == $list[$nb_list - ($spaire - $timeline)]){
                    $key_c2             = $key;
                    $key_c2_wp          = $contender['id_wp'];
                    $list_inf_of_c2     = $contender['more_to'];
                    $list_sup_of_c2     = $contender['less_to'];
                }

            }

            $c1_less_more = array_merge($list_inf_of_c1, $list_sup_of_c1);
            $c2_less_more = array_merge($list_inf_of_c2, $list_sup_of_c2);

            if(in_array($key_c1, $c2_less_more) || in_array($key_c2, $c1_less_more) || ($key_c1 == $key_c2)){

                $battle = false;

                $timeline      = $timeline + 1;
                update_field('timeline_'.$timeline_main, $timeline, $id_ranking);

            }
            else{

                $battle        = true;
                $timeline      = get_field('timeline_'.$timeline_main, $id_ranking);
                array_push($next_duel, $key_c1_wp);
                array_push($next_duel, $key_c2_wp);

            }

        }
        else{

            break;

        }

    }


    return $next_duel;

}
function check_battle_5($id_ranking){

    $array_ratio = array();
    $list_contenders = get_field('ranking_r', $id_ranking);
    array_sort_by_column($list_contenders, 'ratio');
    $user_ranking = array_column($list_contenders, 'ratio', 'id_wp');

    foreach($user_ranking as $c => $p){
        array_push($array_ratio, array(
            "id_wp"             => $c,
            "ratio"             => $p
        ));
    }

    $array_ratio     = array_reverse($array_ratio);
    $list            = $array_ratio;
    $list_inf_of_c1  = array();
    $list_inf_of_c2  = array();
    $list_sup_of_c1  = array();
    $list_sup_of_c2  = array();
    $battle          = false;
    $nb_list         = count($list_contenders);
    $next_duel       = array();
    $timeline        = 0;
    for($m=1;$m<=$nb_list;$m++){


        if($battle == false){
            $timeline               = $timeline + 1;
            foreach($list_contenders as $key => $contender) {
                $array_ratio = array();
                $list_contenders = get_field('ranking_r', $id_ranking);
                array_sort_by_column($list_contenders, 'ratio');
                $user_ranking = array_column($list_contenders, 'ratio', 'id_wp');

                foreach ($user_ranking as $c => $p) {
                    array_push($array_ratio, array(
                        "id_wp" => $c,
                        "ratio" => $p
                    ));
                }

                if ($contender['id_wp'] == $list[$timeline - 1]['id_wp']) {
                    $key_c1 = $contender['id'];
                    $key_c1_wp = $contender['id_wp'];
                    $list_inf_of_c1 = $contender['more_to'];
                    $list_sup_of_c1 = $contender['less_to'];
                }
                if ($contender['id_wp'] == $list[$timeline]['id_wp']) {
                    $key_c2 = $contender['id'];
                    $key_c2_wp = $contender['id_wp'];
                    $list_inf_of_c2 = $contender['more_to'];
                    $list_sup_of_c2 = $contender['less_to'];
                }
            }

            $c1_less_more = array_merge($list_inf_of_c1, $list_sup_of_c1);
            $c2_less_more = array_merge($list_inf_of_c2, $list_sup_of_c2);

            if(in_array($key_c1, $c2_less_more) || in_array($key_c2, $c1_less_more) || ($key_c1 == $key_c2)){

                $battle = false;

            }
            else{

                $battle        = true;
                array_push($next_duel, $key_c1_wp);
                array_push($next_duel, $key_c2_wp);

            }

        }
        else{

            break;

        }

    }

    return $next_duel;

}