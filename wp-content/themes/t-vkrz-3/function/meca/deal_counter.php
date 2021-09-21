<?php
function increase_vote_counter($id_vainkeur){
    
    if($id_vainkeur){

        // Increase user total votes
        $user_vote_counter = get_field('nb_vote_vkrz', $id_vainkeur);
        update_field('nb_vote_vkrz', $user_vote_counter+1, $id_vainkeur);

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

        // Increase VAINKEURZ total tops
        $vkrz_top_counter = get_field('nb_total_tops', 'options');
        update_field('nb_total_tops', $vkrz_top_counter+1, 'options');

        if ($vkrz_top_counter + 1 === 50000) {
            $uuid_winner = get_field('uuid_user_vkrz', $id_vainkeur);
            update_field('50k_top_uuid', $uuid_winner, 'options');
            update_field('50k_tops_id_vainkeur', $id_vainkeur, 'options');
            update_field('50k_tops_date', date('d/m/Y H:i:s'), 'options');

            $event = array(
                'event_name' => '🚨 Le 50 000ème Top vient d\'être terminé 🥳 🥳 🥳  Bravo à tous les Vainkeurs 🤩',
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