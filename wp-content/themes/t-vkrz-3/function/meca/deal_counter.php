<?php
function increase_vote_counter($id_vainkeur){
    
    if($id_vainkeur){

        // Increase user total votes
        $user_vote_counter = get_field('nb_vote_vkrz', $id_vainkeur);
        update_field('nb_vote_vkrz', $user_vote_counter+1, $id_vainkeur);

        // Badge : x votes
        if (!get_vainkeur_badge($id_vainkeur, '1000 votes') || !get_vainkeur_badge($id_vainkeur, '100000 votes')) {
            switch($user_vote_counter+1) {
                case 1000:
                    update_vainkeur_badge($id_vainkeur, '1000 votes');
                    break;
                case 100000:
                    update_vainkeur_badge($id_vainkeur, '100000 votes');
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

        // Increase user total tops
        $user_top_counter = get_field('nb_top_vkrz', $id_vainkeur);
        update_field('nb_top_vkrz', $user_top_counter+1, $id_vainkeur);

        // Badge : First top
        if (!get_vainkeur_badge($id_vainkeur, "First top")) {
            if ($user_top_counter+1 == 1) {
                update_vainkeur_badge($id_vainkeur, "First top");
            }
        }

        // Badge : Night top
        if (!get_vainkeur_badge($id_vainkeur, "Night top")) {
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
                update_vainkeur_badge($id_vainkeur, "Night top");
            }
        }

        // Badge : All categories & Complete category
        if (!get_vainkeur_badge($id_vainkeur, "All categories") || !get_vainkeur_badge($id_vainkeur, "Complete category")) {
            $user_tops = get_user_tops();
            $categories = get_terms(
                array(
                    "taxonomy" => "categorie",
                    "hide_empty" => false,
                )
            );
            $at_least_one_top_by_category = array();
            $complete_category = array();

            foreach($categories as $category) {
                $at_least_one_top_by_category[$category->term_id] = false;
                $complete_category[$category->term_id]["count"] = $category->count;
                $complete_category[$category->term_id]["done"] = 0;
            }

            foreach($user_tops["list_user_tops"] as $top) {
                if($top["state"] == "done"){
                    $at_least_one_top_by_category[$top["cat_t"]] = true;
                    $complete_category[$top["cat_t"]]["done"] = $complete_category[$top["cat_t"]]["done"] + 1;
                }
            }

            if (!in_array(false, $at_least_one_top_by_category)) {
                update_vainkeur_badge($id_vainkeur, "All categories");
            }

            foreach($complete_category as $key => $value) {
                if ($value["done"] == $value["count"]) {
                    update_vainkeur_badge($id_vainkeur, "Complete category id ".$key);
                }
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

function decrease_user_counter($id_vainkeur, $nb_to_decrease, $id_ranking){
    
    if($id_vainkeur){

        // Decrease user total votes
        $user_vote_counter           = get_field('nb_vote_vkrz', $id_vainkeur);
        $user_vote_counter_new_value = $user_vote_counter - $nb_to_decrease;
        update_field('nb_vote_vkrz', $user_vote_counter_new_value, $id_vainkeur);

        // Decrease user total tops
        if(get_field('done_r', $id_ranking) == "done"){
            $user_top_counter           = get_field('nb_top_vkrz', $id_vainkeur);
            $user_top_counter_new_value = $user_top_counter - 1;
            update_field('nb_top_vkrz', $user_top_counter_new_value, $id_vainkeur);
        }

    }

}