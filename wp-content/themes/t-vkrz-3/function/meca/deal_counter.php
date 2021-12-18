<?php
function increase_vote_counter($id_vainkeur){
    
    if($id_vainkeur){

        // Increase user total votes
        $user_vote_counter = get_field('nb_vote_vkrz', $id_vainkeur);
        update_field('nb_vote_vkrz', $user_vote_counter+1, $id_vainkeur);

        // Increase user total money
        $user_money        = get_field('money_vkrz', $id_vainkeur);
        update_field('money_vkrz', $user_money+1, $id_vainkeur);

        // Badge : x votes
        if (!get_vainkeur_badge($id_vainkeur, '1 000 votes') || !get_vainkeur_badge($id_vainkeur, '10 000 votes') || !get_vainkeur_badge($id_vainkeur, '100 000 votes')) {
            switch($user_vote_counter+1) {
                case 1000:
                    update_vainkeur_badge($id_vainkeur, '1 000 votes');
                    break;
                case 100000:
                    update_vainkeur_badge($id_vainkeur, '10 000 votes');
                    break;
                case 1000000:
                    update_vainkeur_badge($id_vainkeur, '100 000 votes');
                    break;
            }
        }

        // Increase VAINKEURZ total votes
        $vkrz_vote_counter = get_field('nb_total_votes', 'options');
        update_field('nb_total_votes', $vkrz_vote_counter+1, 'options');

    }

}

function increase_top_counter($id_vainkeur){
    
    if($id_vainkeur){

        // Increase user total money
        $user_money        = get_field('money_vkrz', $id_vainkeur);
        update_field('money_vkrz', $user_money+5, $id_vainkeur);

        // Increase user total tops
        $user_top_counter = get_field('nb_top_vkrz', $id_vainkeur);
        update_field('nb_top_vkrz', $user_top_counter + 1, $id_vainkeur);

        // Badge : Premier Top
        if (!get_vainkeur_badge($id_vainkeur, "Premier Top")) {
            if ($user_top_counter+1 == 1) {
                update_vainkeur_badge($id_vainkeur, "Premier Top");
            }
        }

        // Badge : Nocturne
        if (!get_vainkeur_badge($id_vainkeur, "Nocturne")) {
            if (
                (
                    strtotime("now") >= strtotime("today 23:30") &&
                    strtotime("now") <= strtotime("tomorrow")
                ) ||
                (
                    strtotime("now") >= strtotime("today") &&
                    strtotime("now") <= strtotime("today 05:00")
                )
            ) {
                update_vainkeur_badge($id_vainkeur, "Nocturne");
            }
        }

        // Increase VAINKEURZ total tops
        $vkrz_top_counter = get_field('nb_total_tops', 'options');
        update_field('nb_total_tops', $vkrz_top_counter+1, 'options');

        if ($vkrz_top_counter + 1 === 100000) {
            $uuid_winner = get_field('uuid_user_vkrz', $id_vainkeur);
            update_field('50k_top_uuid', $uuid_winner, 'options');
            update_field('50k_tops_id_vainkeur', $id_vainkeur, 'options');
            update_field('50k_tops_date', date('d/m/Y H:i:s'), 'options');

            $event = array(
                'event_name' => '🚨 Le 100 000ème Top vient d\'être terminé 🥳 🥳 🥳  Bravo à tous les Vainkeurs 🤩',
                'event_illu' => 'https://vainkeurz.com/wp-content/uploads/2021/08/giphy.gif'
            );
            vkrz_push_event($event);
        }

    }

}

function decrease_user_counter($id_vainkeur, $id_ranking){
    
    if($id_vainkeur){

        // Decrease user total votes
        $user_vote_counter           = get_field('nb_vote_vkrz', $id_vainkeur);
        $nb_to_decrease              = get_field('nb_votes_r', $id_ranking);
        $user_vote_counter_new_value = $user_vote_counter - $nb_to_decrease;
        update_field('nb_vote_vkrz', $user_vote_counter_new_value, $id_vainkeur);

        // Decrease user total tops
        if(get_field('done_r', $id_ranking) == "done"){
            $user_top_counter           = get_field('nb_top_vkrz', $id_vainkeur);
            $user_top_counter_new_value = $user_top_counter - 1;
            update_field('nb_top_vkrz', $user_top_counter_new_value, $id_vainkeur);
        }

        // Decrease user total money
        $user_money        = get_field('money_vkrz', $id_vainkeur);
        update_field('money_vkrz', $user_money - ($nb_to_decrease + 5), $id_vainkeur);

    }

}

function increase_vote_resume($id_top){
    if($id_top){

        $id_resume = get_resume_id($id_top);
        $nb_votes  = get_field('nb_votes_resume', $id_resume);
        $nb_votes++;
        
        update_field('nb_votes_resume', $nb_votes, $id_resume);
    }
}

function increase_top_resume($id_ranking, $infomaj){

    $id_top = get_field('id_tournoi_r', $id_ranking);

    if ($id_top) {

        $id_resume = get_resume_id($id_top);

        if($infomaj == "new"){
            $nb_tops = get_field('nb_tops_resume', $id_resume);
            $nb_tops++;
            update_field('nb_tops_resume', $nb_tops, $id_resume);

            $type_top_3         = get_field('nb_top_3_resume', $id_resume);
            $type_top_complet   = get_field('nb_top_complet_resume', $id_resume);
            if (get_field('type_top_r', $id_ranking) == "top3") {
                $type_top_3++;
            } elseif (get_field('type_top_r', $id_ranking) == "complet") {
                $type_top_complet++;
            }
            update_field('nb_top_3_resume', $type_top_3, $id_resume);
            update_field('nb_top_complet_resume', $type_top_complet, $id_resume);
        }

        if ($infomaj == "finish") {
            $nb_tops_complete   = get_field("nb_done_resume", $id_resume);
            if (get_field('done_r', $id_ranking) == "done") {
                $nb_tops_complete++;
            }
            update_field('nb_done_resume', $nb_tops_complete, $id_resume);
            
            $nb_tops_triche     = get_field('nb_triche_resume', $id_resume);
            if (get_field('suspected_cheating_r', $id_ranking)) {
                $nb_tops_triche++;
            }
            update_field('nb_triche_resume', $nb_tops_triche, $id_resume);
        }

        if ($infomaj == "again") {
            $nb_tops_again      = get_field('nb_again_resume', $id_resume);
            if (get_post_status($id_ranking) == 'draft') {
                $nb_tops_again++;
            }
            update_field('nb_again_resume', $nb_tops_again, $id_resume);
        }
    }
}