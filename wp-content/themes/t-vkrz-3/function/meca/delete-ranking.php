<?php
function delete_ranking($id_ranking, $id_vainkeur){

    if(isset($id_ranking) && $id_ranking != ""){

        $id_top             = get_field('id_tournoi_r', $id_ranking);
        $nb_to_decrease     = get_field('nb_votes_r', $id_ranking);
        decrease_user_counter($id_vainkeur, $nb_to_decrease, $id_ranking);

        wp_update_post(array(
            'ID'            =>  $id_ranking,
            'post_status'   =>  'draft'
        ));

    }

    if (is_user_logged_in()) {
        delete_transient('user_' . get_current_user_id() . '_get_user_tops');
    }

    return die(json_encode( array(
        'id_ranking'        => $id_ranking,
        'id_top'            => $id_top,
        'url_top'           => get_permalink($id_top)
    )));

}

function delete_real_ranking($id_ranking, $id_vainkeur){

    if(isset($id_ranking) && $id_ranking != ""){

        $nb_to_decrease     = get_field('nb_votes_r', $id_ranking);
        decrease_user_counter($id_vainkeur, $nb_to_decrease, $id_ranking);

        wp_trash_post($id_ranking);

    }

    if (is_user_logged_in()) {
        delete_transient('user_' . get_current_user_id() . '_get_user_tops');
    }
    
    return die(json_encode( array(
        'id_ranking'        => $id_ranking,
    )));

}