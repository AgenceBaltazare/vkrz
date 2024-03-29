<?php
function increase_vote_counter($id_vainkeur)
{

    if ($id_vainkeur) {

        // Increase user total votes
        $user_vote_counter = get_field('nb_vote_vkrz', $id_vainkeur);
        update_field('nb_vote_vkrz', $user_vote_counter + 1, $id_vainkeur);

        // Increase user total money
        $user_money        = get_field('money_vkrz', $id_vainkeur);
        update_field('money_vkrz', $user_money + 1, $id_vainkeur);

        $user_money_dispo  = get_field('money_disponible_vkrz', $id_vainkeur);
        update_field('money_disponible_vkrz', $user_money_dispo + 1, $id_vainkeur);

        // Badge : x votes
        if (!get_vainkeur_badge($id_vainkeur, '1 000 votes') || !get_vainkeur_badge($id_vainkeur, '10 000 votes') || !get_vainkeur_badge($id_vainkeur, '100 000 votes')) {
            switch ($user_vote_counter + 1) {
                case 1000:
                    update_vainkeur_badge($id_vainkeur, '1 000 votes');
                    break;
                case 10000:
                    update_vainkeur_badge($id_vainkeur, '10 000 votes');
                    break;
                case 100000:
                    update_vainkeur_badge($id_vainkeur, '100 000 votes');
                    break;
            }
        }

        // Increase VAINKEURZ total votes
        $vkrz_vote_counter = get_field('nb_total_votes', 'options');
        update_field('nb_total_votes', $vkrz_vote_counter + 1, 'options');

        if ($vkrz_vote_counter + 1 === 5000000) {
            $uuid_winner = get_field('uuid_user_vkrz', $id_vainkeur);
            update_field('uuid_5m_votes', $uuid_winner, 'options');
            update_field('id_vkrz_5m_votes', $id_vainkeur, 'options');
            update_field('date_5m_votes', date('d/m/Y H:i:s'), 'options');

            $event = array(
                'event_name' => '🚨 Le 5 000 000ème vote vient d\'être fait 🥳 🥳 🥳',
                'event_illu' => 'https://vainkeurz.com/wp-content/uploads/2021/08/giphy.gif'
            );
            vkrz_push_event($event);
        }
    }
}

function increase_top_counter($id_vainkeur)
{

    if ($id_vainkeur) {

        // Increase user total money
        $user_money        = get_field('money_vkrz', $id_vainkeur);
        update_field('money_vkrz', $user_money + 5, $id_vainkeur);

        $user_money_dispo  = get_field('money_disponible_vkrz', $id_vainkeur);
        update_field('money_disponible_vkrz', $user_money_dispo + 5, $id_vainkeur);

        // Increase user total tops
        $user_top_counter = get_field('nb_top_vkrz', $id_vainkeur);
        update_field('nb_top_vkrz', $user_top_counter + 1, $id_vainkeur);

        // Badge : Premier Top
        if (!get_vainkeur_badge($id_vainkeur, "Premier Top")) {
            if ($user_top_counter + 1 == 1) {
                update_vainkeur_badge($id_vainkeur, "Premier Top");
            }
        }

        // Badge : GP Explorer
        if (!get_vainkeur_badge($id_vainkeur, "GP Explorer")) {
            $list_tops_done = array();
            $top_gpexplorer = array();
            $list_tops_done = json_decode(get_field('liste_des_top_vkrz', $id_vainkeur));
            $top_gpexplorer = get_field('liste_des_tops_room', 484210);
            $all_done       = true;
            foreach ($top_gpexplorer as $top) {
                if (!in_array($top, $list_tops_done)) {
                    $all_done = false;
                }
            }
            if ($all_done == true) {
                update_vainkeur_badge($id_vainkeur, "GP Explorer");
            }
        }

        // Badge : Nocturne
        if (!get_vainkeur_badge($id_vainkeur, "Nocturne")) {
            if (
                (strtotime("now") >= strtotime("today 23:30") &&
                    strtotime("now") <= strtotime("tomorrow")
                ) ||
                (strtotime("now") >= strtotime("today") &&
                    strtotime("now") <= strtotime("today 05:00")
                )
            ) {
                update_vainkeur_badge($id_vainkeur, "Nocturne");
            }
        }

        // Increase VAINKEURZ total tops
        $vkrz_top_counter = get_field('nb_total_tops', 'options');
        update_field('nb_total_tops', $vkrz_top_counter + 1, 'options');

        if ($vkrz_top_counter + 1 === 200000) {
            $uuid_topeur = get_field('uuid_user_vkrz', $id_vainkeur);
            update_field('200k_top_uuid', $uuid_topeur, 'options');
            update_field('200k_tops_id_vainkeur', $id_vainkeur, 'options');
            update_field('200k_tops_date', date('d/m/Y H:i:s'), 'options');

            $event = array(
                'event_name' => '🚨 La 200 000ème TopList vient d\'être faite 🥳 🥳 🥳',
                'event_illu' => 'https://vainkeurz.com/wp-content/uploads/2021/08/giphy.gif'
            );
            vkrz_push_event($event);
        }
    }
}

function decrease_user_counter($id_vainkeur, $id_ranking)
{

    if ($id_vainkeur) {

        $nb_to_decrease              = 0;
        // Decrease user total votes
        $user_vote_counter           = get_field('nb_vote_vkrz', $id_vainkeur);
        $nb_to_decrease              = get_field('nb_votes_r', $id_ranking);
        $user_vote_counter_new_value = $user_vote_counter - $nb_to_decrease;
        if ($user_vote_counter_new_value <= 0) {
            $user_vote_counter_new_value = 0;
        }
        update_field('nb_vote_vkrz', $user_vote_counter_new_value, $id_vainkeur);

        // Decrease user total tops
        if (get_field('done_r', $id_ranking) == "done") {
            $user_top_counter           = get_field('nb_top_vkrz', $id_vainkeur);
            $user_top_counter_new_value = $user_top_counter - 1;
            $nb_to_decrease             = $nb_to_decrease + 5;
            if ($user_top_counter_new_value <= 0) {
                $user_top_counter_new_value = 0;
            }
            update_field('nb_top_vkrz', $user_top_counter_new_value, $id_vainkeur);
        }

        // Decrease user total money
        $user_money        = get_field('money_vkrz', $id_vainkeur);
        if ($user_money <= 0) {
            $user_money = 0;
        }
        update_field('money_vkrz', $user_money - $nb_to_decrease, $id_vainkeur);

        $user_money_dispo = get_field('money_disponible_vkrz', $id_vainkeur);
        if ($user_money_dispo <= 0) {
            $user_money_dispo = 0;
        }
        update_field('money_disponible_vkrz', $user_money_dispo - $nb_to_decrease, $id_vainkeur);
    }
}

function increase_vote_resume($id_top)
{
    if ($id_top) {

        $id_resume = get_resume_id($id_top);
        $nb_votes  = get_field('nb_votes_resume', $id_resume);
        $nb_votes++;

        update_field('nb_votes_resume', $nb_votes, $id_resume);
    }
}

function increase_top_resume($id_ranking, $infomaj)
{

    $id_top = get_field('id_tournoi_r', $id_ranking);

    if ($id_top) {

        $id_resume = get_resume_id($id_top);

        if ($infomaj == "new") {
            $nb_tops = get_field('nb_tops_resume', $id_resume);
            $nb_tops++;
            update_field('nb_tops_resume', $nb_tops, $id_resume);

            if (get_field('type_top_r', $id_ranking) == "top3") {
                $type_top_3         = get_field('nb_top_3_resume', $id_resume);
                $type_top_3++;
                update_field('nb_top_3_resume', $type_top_3, $id_resume);
            } elseif (get_field('type_top_r', $id_ranking) == "complet") {
                $type_top_complet   = get_field('nb_top_complet_resume', $id_resume);
                $type_top_complet++;
                update_field('nb_top_complet_resume', $type_top_complet, $id_resume);
            }
        }

        if ($infomaj == "finish") {
            if (get_field('done_r', $id_ranking) == "done") {
                $nb_tops_complete   = get_field("nb_done_resume", $id_resume);
                $nb_tops_complete++;
                update_field('nb_done_resume', $nb_tops_complete, $id_resume);
            }

            if (get_field('suspected_cheating_r', $id_ranking)) {
                $nb_tops_triche     = get_field('nb_triche_resume', $id_resume);
                $nb_tops_triche++;
                update_field('nb_triche_resume', $nb_tops_triche, $id_resume);
            }

            // Mise à jour de la liste des TopList du résumé
            $resume_list_toplist = array();
            if (get_field('all_toplist_resume', $id_resume)) {
                $resume_list_toplist = json_decode(get_field('all_toplist_resume', $id_resume));
            }
            if (!in_array(intval($id_ranking), $resume_list_toplist)) {
                array_push($resume_list_toplist, intval($id_ranking));
                update_field('all_toplist_resume', json_encode($resume_list_toplist), $id_resume);
            }
        }

        if ($infomaj == "again") {
            $nb_tops_again = get_field('nb_again_resume', $id_resume);
            $nb_tops_again++;
            update_field('nb_again_resume', $nb_tops_again, $id_resume);

            // Diminution du compteur de Top 
            $nb_tops = get_field('nb_tops_resume', $id_resume);
            $nb_tops = $nb_tops - 1;
            update_field('nb_tops_resume', $nb_tops, $id_resume);

            if (get_field('type_top_r', $id_ranking) == "top3") {
                $type_top_3 = get_field('nb_top_3_resume', $id_resume);
                $type_top_3 = $type_top_3 - 1;
                update_field('nb_top_3_resume', $type_top_3, $id_resume);
            } elseif (get_field('type_top_r', $id_ranking) == "complet") {
                $type_top_complet = get_field('nb_top_complet_resume', $id_resume);
                $type_top_complet = $type_top_complet - 1;
                update_field('nb_top_complet_resume', $type_top_complet, $id_resume);
            }

            // Mise à jour de la liste des TopList du résumé
            $resume_list_toplist = array();
            if (get_field('all_toplist_resume', $id_resume)) {
                $resume_list_toplist = json_decode(get_field('all_toplist_resume', $id_resume));
            }
            $resume_list_toplist = array_diff($resume_list_toplist, array($id_ranking));
            $resume_list_toplist = '[' . implode(',', $resume_list_toplist) . "]";
            update_field('all_toplist_resume', $resume_list_toplist, $id_resume);
        }
    }
}
