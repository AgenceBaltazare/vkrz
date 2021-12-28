<?php
function get_next_duel($id_ranking, $id_top, $current_id_vainkeur){

    global $id_vainkeur;
    $next_duel          = [];
    $is_next_duel       = true;
    $contender_1        = 0;
    $contender_2        = 0;

    $next_duel          = array();
    $typetop            = get_field('type_top_r', $id_ranking);

    $list_w_r           = get_field('list_winners_r', $id_ranking);
    if (!$list_w_r) {
        $list_w_r = array();
    }
    $list_l_r           = get_field('list_losers_r', $id_ranking);
    if (!$list_l_r) {
        $list_l_r = array();
    }
    $timeline_votes     = get_field('nb_votes_r', $id_ranking);
    $list_contenders    = get_field('ranking_r', $id_ranking);

    // Count contenders
    $nb_contenders = count($list_contenders);
    if ($nb_contenders % 2 == 0) {
        // Paire
        $spaire = 5;
    } else {
        // Impaire
        $spaire = 6;
    }


    if (isset($typetop) && $typetop == "top3") {


        $halfinf = intval(floor($nb_contenders / 2));
        $halfsup = round(($nb_contenders / 2), 0, PHP_ROUND_HALF_UP);
        $timeline_main = get_field('timeline_main', $id_ranking);

        if ($timeline_main == 1) {

            if ($timeline_votes == $halfinf) {
                $timeline_main = 2;
                update_field('timeline_main', 2, $id_ranking);

            } else {

                $key_c_1 = $nb_contenders - (1 + $timeline_votes);
                $key_c_2 = $nb_contenders - (1 + $halfinf + $timeline_votes);

                array_push($next_duel, $list_contenders[$key_c_1]['id_wp']);
                array_push($next_duel, $list_contenders[$key_c_2]['id_wp']);

            }

        }


        if ($timeline_main == 2) {

            $list_inf       = get_contenders_top_3_2($id_ranking);
            $nb_list_inf    = count($list_inf);
            $random         = rand(2, $nb_list_inf);

            if ($nb_list_inf == 1) {
                $timeline_main = 3;
                update_field('timeline_main', 3, $id_ranking);

            } else {

                $key_c_1 = $list_inf[$random - 2];
                $key_c_2 = $list_inf[$random - 1];
                array_push($next_duel, $key_c_1);
                array_push($next_duel, $key_c_2);

            }


        }

        if ($timeline_main == 3) {

            $list_inf       = get_contenders_top_3_3($id_ranking);
            $nb_list_inf    = count($list_inf);
            $random         = rand(2, $nb_list_inf);

            if ($nb_list_inf == 1) {
                $timeline_main = 4;
                update_field('timeline_main', 4, $id_ranking);

            } else {

                $key_c_1 = $list_inf[$random - 2];
                $key_c_2 = $list_inf[$random - 1];
                array_push($next_duel, $key_c_1);
                array_push($next_duel, $key_c_2);

            }

        }

        if ($timeline_main == 4) {

            $list_inf       = get_contenders_top_3_4($id_ranking);
            $nb_list_inf    = count($list_inf);
            $random         = rand(2, $nb_list_inf);

            if ($nb_list_inf == 1) {

                $is_next_duel = false;

                if (!get_field('done_r', $id_ranking)) {
                    date_default_timezone_set('Europe/Paris');
                    $is_suspected_cheating = suspected_cheating(get_the_date('Y-m-d H:i:s', $id_ranking), date('Y-m-d H:i:s'), get_field('nb_votes_r', $id_ranking));
                    update_field('done_r', 'done', $id_ranking);
                    update_field('done_date_r', date('Y-m-d H:i:s'), $id_ranking);
                    update_field('suspected_cheating_r', $is_suspected_cheating, $id_ranking);

                    if (!in_array($id_top, get_exclude_top())) {
                        increase_top_counter($current_id_vainkeur, $id_top);
                        increase_top_resume($id_ranking, 'finish');
                    }

                    // Badge : Top with at least 50 contenders
                    if (!get_vainkeur_badge($current_id_vainkeur, "BIG TOP")) {
                        if ($nb_contenders >= 50) {
                            update_vainkeur_badge($current_id_vainkeur, "BIG TOP");
                        }
                    }

                    // Badge : Top with at least 100 contenders
                    if (!get_vainkeur_badge($current_id_vainkeur, "BIG BIG TOP")) {
                        if ($nb_contenders >= 100) {
                            update_vainkeur_badge($current_id_vainkeur, "BIG BIG TOP");
                        }
                    }

                }

                if (is_user_logged_in()) {
                    delete_transient( 'user_'.get_current_user_id().'_get_user_tops' );
                }

            } else {

                $key_c_1 = $list_inf[$random - 2];
                $key_c_2 = $list_inf[$random - 1];
                array_push($next_duel, $key_c_1);
                array_push($next_duel, $key_c_2);

            }

        }

    } else {

        // Timeline Main
        if($nb_contenders >= 10){
            if($timeline_votes == $nb_contenders-5){
                update_field('timeline_main', 2, $id_ranking);
            }
        }
        else{
            if($timeline_votes < $nb_contenders - 1){
                update_field('timeline_main', 6, $id_ranking);
                $timeline_main = 6;
            }
            else{
                update_field('timeline_main', 7, $id_ranking);
                $timeline_main = 7;
            }
        }
        $timeline_main = get_field('timeline_main', $id_ranking);

        if ($timeline_main == 1) {

            $key_c_1 = $nb_contenders - (1 + $timeline_votes);
            $key_c_2 = $nb_contenders - (6 + $timeline_votes);

            array_push($next_duel, $list_contenders[$key_c_1]['id_wp']);
            array_push($next_duel, $list_contenders[$key_c_2]['id_wp']);

        }

        if ($timeline_main == 2) {

            $timeline_2 = get_field('timeline_2', $id_ranking);
            $timeline = $timeline_2;
            $list = $list_l_r;

            $next_duel = check_battle_2($id_ranking, $list, $timeline, $timeline_main);

            if (count($next_duel) != 2) {

                $timeline_main = 3;
                update_field('timeline_main', 3, $id_ranking);

            }

        }

        if ($timeline_main == 3) {

            $nb_loosers = count($list_l_r) - 1;

            foreach ($list_contenders as $key => $contender) {

                if ($contender['id_wp'] == $list_l_r[$nb_loosers]) {
                    $key_c1 = $key;
                    $list_inf_of_c1 = $contender['more_to'];
                    $list_sup_of_c1 = $contender['less_to'];
                }

                if ($contender['id_wp'] == $list_w_r[count($list_w_r) - $spaire]) {
                    $key_c2 = $key;
                    $list_inf_of_c2 = $contender['more_to'];
                    $list_sup_of_c2 = $contender['less_to'];
                }

            }

            $c1_less_more = array_merge($list_inf_of_c1, $list_sup_of_c1);
            $c2_less_more = array_merge($list_inf_of_c2, $list_sup_of_c2);

            if (in_array($key_c1, $c2_less_more) || in_array($key_c2, $c1_less_more) || ($key_c1 == $key_c2)) {

                update_field('timeline_main', 4, $id_ranking);
                $timeline_main = 4;

            } else {

                array_push($next_duel, $list_l_r[$nb_loosers]);
                array_push($next_duel, $list_w_r[count($list_w_r) - $spaire]);

            }
            update_field('timeline_4', 1, $id_ranking);

        }

        if ($timeline_main == 4) {

            $timeline = get_field('timeline_4', $id_ranking);
            $list = $list_w_r;

            $next_duel = check_battle_4($id_ranking, $list, $timeline, $timeline_main, $spaire);

            if (count($next_duel) != 2) {

                $timeline_main = 5;
                update_field('timeline_main', 5, $id_ranking);
                $next_duel = check_battle_5($id_ranking);

                if (count($next_duel) != 2) {

                    $is_next_duel = false;

                    if (!get_field('done_r', $id_ranking)) {
                        date_default_timezone_set('Europe/Paris');
                        $is_suspected_cheating = suspected_cheating(get_the_date('Y-m-d H:i:s', $id_ranking), date('Y-m-d H:i:s'), get_field('nb_votes_r', $id_ranking));

                        update_field('done_r', 'done', $id_ranking);
                        update_field('done_date_r', date('Y-m-d H:i:s'), $id_ranking);
                        update_field('suspected_cheating_r', $is_suspected_cheating, $id_ranking);

                        if (!in_array($id_top, get_exclude_top())) {
                            increase_top_counter($current_id_vainkeur, $id_top);
                            increase_top_resume($id_ranking, 'finish');
                        }

                        // Badge : Top with at least 50 contenders
                        if (!get_vainkeur_badge($current_id_vainkeur, "BIG TOP")) {
                            if ($nb_contenders >= 50) {
                                update_vainkeur_badge($current_id_vainkeur, "BIG TOP");
                            }
                        }

                        // Badge : Top with at least 100 contenders
                        if (!get_vainkeur_badge($current_id_vainkeur, "BIG BIG TOP")) {
                            if ($nb_contenders >= 100) {
                                update_vainkeur_badge($current_id_vainkeur, "BIG BIG TOP");
                            }
                        }
                    }

                    if (is_user_logged_in()) {
                        delete_transient( 'user_'.get_current_user_id().'_get_user_tops' );
                    }
                    
                }

            }

        }

        if ($timeline_main == 5) {

            $timeline_main = 5;
            update_field('timeline_main', 5, $id_ranking);

            $next_duel = check_battle_5($id_ranking);

            if (count($next_duel) != 2) {

                $is_next_duel = false;

                if (!get_field('done_r', $id_ranking)) {
                    date_default_timezone_set('Europe/Paris');
                    $is_suspected_cheating = suspected_cheating(get_the_date('Y-m-d H:i:s', $id_ranking), date('Y-m-d H:i:s'), get_field('nb_votes_r', $id_ranking));

                    update_field('done_r', 'done', $id_ranking);
                    update_field('done_date_r', date('Y-m-d H:i:s'), $id_ranking);
                    update_field('suspected_cheating_r', $is_suspected_cheating, $id_ranking);

                    if (!in_array($id_top, get_exclude_top())) {
                        increase_top_counter($current_id_vainkeur, $id_top);
                        increase_top_resume($id_ranking, 'finish');
                    }

                    // Badge : Top with at least 50 contenders
                    if (!get_vainkeur_badge($current_id_vainkeur, "BIG TOP")) {
                        if ($nb_contenders >= 50) {
                            update_vainkeur_badge($current_id_vainkeur, "BIG TOP");
                        }
                    }

                    // Badge : Top with at least 100 contenders
                    if (!get_vainkeur_badge($current_id_vainkeur, "BIG BIG TOP")) {
                        if ($nb_contenders >= 100) {
                            update_vainkeur_badge($current_id_vainkeur, "BIG BIG TOP");
                        }
                    }
                }

                if (is_user_logged_in()) {
                    delete_transient( 'user_'.get_current_user_id().'_get_user_tops' );
                }

            }

        }

        if($timeline_main == 6){

            $timeline_main = 6;
            update_field('timeline_main', 6, $id_ranking);

            $key_c_1 = $nb_contenders - (2 + $timeline_votes);
            $key_c_2 = $nb_contenders - (1 + $timeline_votes);

            array_push($next_duel, $list_contenders[$key_c_1]['id_wp']);
            array_push($next_duel, $list_contenders[$key_c_2]['id_wp']);

        }


        if($timeline_main == 7){

            $timeline_main = 7;
            update_field('timeline_main', 7, $id_ranking);

            $next_duel     = check_battle_5($id_ranking);

            if(count($next_duel) != 2){

                $is_next_duel = false;

                if(!get_field('done_r', $id_ranking)){
                    date_default_timezone_set('Europe/Paris');
                    $is_suspected_cheating = suspected_cheating(get_the_date('Y-m-d H:i:s', $id_ranking), date('Y-m-d H:i:s'), get_field('nb_votes_r', $id_ranking));
                    
                    update_field('done_r', 'done', $id_ranking);
                    update_field('done_date_r', date('Y-m-d H:i:s'), $id_ranking);
                    update_field('suspected_cheating_r', $is_suspected_cheating, $id_ranking);
                    if (!in_array($id_top, get_exclude_top())) {
                        increase_top_counter($current_id_vainkeur, $id_top);
                        increase_top_resume($id_ranking, 'finish');
                    }

                    // Badge : Top with at least 50 contenders
                    if (!get_vainkeur_badge($current_id_vainkeur, "BIG TOP")) {
                        if ($nb_contenders >= 50) {
                            update_vainkeur_badge($current_id_vainkeur, "BIG TOP");
                        }
                    }

                    // Badge : Top with at least 100 contenders
                    if (!get_vainkeur_badge($current_id_vainkeur, "BIG BIG TOP")) {
                        if ($nb_contenders >= 100) {
                            update_vainkeur_badge($current_id_vainkeur, "BIG BIG TOP");
                        }
                    }
                }

                if (is_user_logged_in()) {
                    delete_transient( 'user_'.get_current_user_id().'_get_user_tops' );
                }

            }

        }

    }

    $nb_user_votes = all_user_votes_in_top($id_ranking);

    if ($is_next_duel) {
        $val1 = random_int(0, 1);
        if ($val1 == 0) {
            $val2 = 1;
        } else {
            $val2 = 0;
        }
        $contender_1 = $next_duel[$val1];
        $contender_2 = $next_duel[$val2];
    }

    $current_step = get_steps($id_ranking);

    return compact(
        'is_next_duel',
        'contender_1',
        'contender_2',
        'current_step',
        'timeline_main',
        'nb_user_votes',
        'nb_contenders',
        'id_top',
        'id_ranking',
        'current_id_vainkeur'
    );
}