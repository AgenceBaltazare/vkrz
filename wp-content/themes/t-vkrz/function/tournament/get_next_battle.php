<?php
function get_next_duel( $id_ranking, $id_tournament) {

    $next_duel               = [];
    $is_next_duel            = true;
    $contender_1             = 0;
    $contender_2             = 0;

    $next_duel = array();

    $list_w_r        = get_field('list_winners_r', $id_ranking);
    if(!$list_w_r){
        $list_w_r    = array();
    }
    $list_l_r        = get_field('list_losers_r', $id_ranking);
    if(!$list_l_r){
        $list_l_r    = array();
    }
    $timeline_votes  = get_field('nb_votes_r', $id_ranking);
    $list_contenders = get_field('ranking_r', $id_ranking);


    // Count contenders
    $nb_contenders      = count($list_contenders);
    if($nb_contenders % 2 == 0){
        // Paire
        $spaire = 5;
    }
    else{
        // Impaire
        $spaire = 6;
    }

    // Timeline Main
    if($nb_contenders >= 10){
        if($timeline_votes == $nb_contenders-5){
            update_field('timeline_main', 2, $id_ranking);
        }
    }
    else{
        update_field('timeline_main', 6, $id_ranking);
    }
    $timeline_main = get_field('timeline_main', $id_ranking);

    if($timeline_main == 1){

        $key_c_1 = $nb_contenders - (1 + $timeline_votes);
        $key_c_2 = $nb_contenders - (6 + $timeline_votes);

        array_push($next_duel, $list_contenders[$key_c_1]['id_wp']);
        array_push($next_duel, $list_contenders[$key_c_2]['id_wp']);

    }

    elseif($timeline_main == 2){

        $timeline_2      = get_field('timeline_2', $id_ranking);

        foreach($list_contenders as $key => $contender) {

            if($contender['id_wp'] == $list_l_r[$timeline_2 - 1]){
                $key_c1             = $key;
                $list_inf_of_c1     = $contender['more_to'];
                $list_sup_of_c1     = $contender['less_to'];
            }

            if($contender['id_wp'] == $list_l_r[$timeline_2]){
                $key_c2             = $key;
                $list_inf_of_c2     = $contender['more_to'];
                $list_sup_of_c2     = $contender['less_to'];
            }

        }

        $c1_less_more = array_merge($list_inf_of_c1, $list_sup_of_c1);
        $c2_less_more = array_merge($list_inf_of_c2, $list_sup_of_c2);

        if(in_array($key_c1, $c2_less_more) || in_array($key_c2, $c1_less_more)){

            $timeline_2      = $timeline_2 + 1;
            update_field('timeline_2', $timeline_2, $id_ranking);

        }

        array_push($next_duel, $list_l_r[$timeline_2 - 1]);
        array_push($next_duel, $list_l_r[$timeline_2]);
    }

    elseif($timeline_main == 3){

        $nb_loosers      = count($list_l_r) - 1;

        foreach($list_contenders as $key => $contender) {

            if($contender['id_wp'] == $list_l_r[$nb_loosers]){
                $key_c1             = $key;
                $list_inf_of_c1     = $contender['more_to'];
                $list_sup_of_c1     = $contender['less_to'];
            }

            if($contender['id_wp'] == $list_w_r[count($list_w_r) - $spaire]){
                $key_c2             = $key;
                $list_inf_of_c2     = $contender['more_to'];
                $list_sup_of_c2     = $contender['less_to'];
            }

        }

        $c1_less_more = array_merge($list_inf_of_c1, $list_sup_of_c1);
        $c2_less_more = array_merge($list_inf_of_c2, $list_sup_of_c2);

        if(in_array($key_c1, $c2_less_more) || in_array($key_c2, $c1_less_more) || ($key_c1 == $key_c2)){

            update_field('timeline_main', 4, $id_ranking);

            $timeline_4      = get_field('timeline_4', $id_ranking);

            foreach($list_contenders as $key => $contender) {

                if($contender['id_wp'] == $list_w_r[count($list_w_r) - ($spaire + $timeline_4 - 1)]){
                    $key_c1             = $key;
                    $key_c1_wp          = $contender['id_wp'];
                    $list_inf_of_c1     = $contender['more_to'];
                    $list_sup_of_c1     = $contender['less_to'];
                }
                if($contender['id_wp'] == $list_w_r[count($list_w_r) - ($spaire + $timeline_4)]){
                    $key_c2             = $key;
                    $key_c2_wp          = $contender['id_wp'];
                    $list_inf_of_c2     = $contender['more_to'];
                    $list_sup_of_c2     = $contender['less_to'];
                }

            }

            $c1_less_more = array_merge($list_inf_of_c1, $list_sup_of_c1);
            $c2_less_more = array_merge($list_inf_of_c2, $list_sup_of_c2);

            if(in_array($key_c1, $c2_less_more) || in_array($key_c2, $c1_less_more)){

                $timeline_4      = $timeline_4 + 1;
                update_field('timeline_4', $timeline_4, $id_ranking);

            }

            array_push($next_duel, $key_c1_wp);
            array_push($next_duel, $key_c2_wp);

        }
        else{

            array_push($next_duel, $list_l_r[$nb_loosers]);
            array_push($next_duel, $list_w_r[count($list_w_r) - $spaire]);

        }

    }

    elseif($timeline_main == 4){

        $timeline_4      = get_field('timeline_4', $id_ranking);

        foreach($list_contenders as $key => $contender) {

            if($contender['id_wp'] == $list_w_r[count($list_w_r) - ($spaire - ($timeline_4 - 1))]){
                $key_c1             = $key;
                $key_c1_wp          = $contender['id_wp'];
                $list_inf_of_c1     = $contender['more_to'];
                $list_sup_of_c1     = $contender['less_to'];
            }
            if($contender['id_wp'] == $list_w_r[count($list_w_r) - ($spaire - $timeline_4)]){
                $key_c2             = $key;
                $key_c2_wp          = $contender['id_wp'];
                $list_inf_of_c2     = $contender['more_to'];
                $list_sup_of_c2     = $contender['less_to'];
            }

        }

        $c1_less_more = array_merge($list_inf_of_c1, $list_sup_of_c1);
        $c2_less_more = array_merge($list_inf_of_c2, $list_sup_of_c2);

        if(in_array($key_c1, $c2_less_more) || in_array($key_c2, $c1_less_more)){

            $timeline_4      = $timeline_4 + 1;
            update_field('timeline_4', $timeline_4, $id_ranking);

        }

        array_push($next_duel, $key_c1_wp);
        array_push($next_duel, $key_c2_wp);

    }

    elseif($timeline_main == 5){

        $is_same_ratio   = false;
        $is_same_place   = false;
        $c_at_same_place = array();
        $c_at_same_ratio = array();

        // On lance des boucles jusqu'à obtenir le tableau "$next_duel" avec deux valeurs
        // On lance autant de boucle que de participant-1

        for($s = 0; $s <= $nb_contenders-1; $s++){

            // Si le tableau "$next_duel" est supérieur ou égal à deux valeurs alors on stop car nous pouvons faire un nouveau duel
            // Sinon on le remet à zéro
            if(count($c_at_same_place) >= 2){
                break;
            }
            else{
                $c_at_same_place = array();
            }

            // On boucle sur tous les participant et on stocke leur ID global quand leur place est égal à l'incrémentation
            foreach ($list_contenders as $d => $val){

                if($val['place'] == $s){
                    array_push($c_at_same_place, $val['id_wp']);
                }

            }

        }

        array_filter($c_at_same_place);

        if(count($c_at_same_place) >= 2){
            $is_same_place = true;
            array_push($next_duel, $c_at_same_place[0]);
            array_push($next_duel, $c_at_same_place[1]);
        }

        if(!$is_same_place){
            // On lance des boucles jusqu'à obtenir le tableau "$next_duel" avec deux valeurs
            // On lance autant de boucle que de participant-1
            for($s = 0; $s <= $nb_contenders-1; $s++){

                // Si le tableau "$next_duel" est supérieur ou égal à deux valeurs alors on stop car nous pouvons faire un nouveau duel
                // Sinon on le remet à zéro
                if(count($c_at_same_ratio) >= 2){
                    break;
                }
                else{
                    $c_at_same_ratio = array();
                }

                // On boucle sur tous les participant et on stocke leur ID global quand leur place est égal à l'incrémentation
                foreach ($list_contenders as $d => $val){

                    if($val['ratio'] == $s){
                        array_push($c_at_same_ratio, $val['id_wp']);
                    }

                }

            }

            array_filter($c_at_same_ratio);

            if(count($c_at_same_ratio) >= 2){
                $is_same_ratio = true;
                array_push($next_duel, $c_at_same_ratio[0]);
                array_push($next_duel, $c_at_same_ratio[1]);
            }
        }

        if(!$is_same_ratio && !$is_same_place){
            $is_next_duel = false;
            if(!get_field('done_r', $id_ranking)){
                update_field('done_r', 'done', $id_ranking);
                update_field('done_date_r', date('d/m/Y'), $id_ranking);
            }
        }

    }

    elseif($timeline_main == 6){

        $c_at_same_place = array();

        for($s = 0; $s <= $nb_contenders-1; $s++){

            if(count($c_at_same_place) >= 2){
                break;
            }
            else{
                $c_at_same_place = array();
            }
            foreach ($list_contenders as $d => $val){

                if($val['place'] == $s){
                    array_push($c_at_same_place, $val['id_wp']);
                }

            }

        }

        array_filter($c_at_same_place);

        if(count($c_at_same_place) >= 2){
            array_push($next_duel, $c_at_same_place[0]);
            array_push($next_duel, $c_at_same_place[1]);
        }
        else{
            $is_next_duel = false;
            if(!get_field('done_r', $id_ranking)){
                update_field('done_r', 'done', $id_ranking);
                update_field('done_date_r', date('d/m/Y'), $id_ranking);
            }
        }

    }

    $all_votes_counts = all_votes_in_tournament($id_tournament);
    $nb_user_votes    = all_user_votes_in_tournament($id_ranking);

    if($is_next_duel){
        $val1 = random_int(0, 1);
        if($val1 == 0){
            $val2 = 1;
        }
        else{
            $val2 = 0;
        }
        $contender_1      = $next_duel[$val1];
        $contender_2      = $next_duel[$val2];
    }

    $current_step = get_steps($id_ranking);

    return compact(
        'is_next_duel',
        'contender_1',
        'contender_2',
        'current_step',
        'timeline_main',
        'all_votes_counts',
        'nb_user_votes',
        'nb_contenders',
        'id_tournament'
    );

}