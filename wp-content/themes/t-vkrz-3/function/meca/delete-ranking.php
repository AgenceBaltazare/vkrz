<?php
function delete_ranking($id_ranking, $id_vainkeur){

    if(isset($id_ranking) && $id_ranking != ""){

        $id_top             = get_field('id_tournoi_r', $id_ranking);
        $nb_to_decrease     = get_field('nb_votes_r', $id_ranking);
        decrease_user_counter($id_vainkeur, $nb_to_decrease);

        wp_update_post(array(
            'ID'            =>  $id_ranking,
            'post_status'   =>  'draft'
        ));

    }

    return die(json_encode( array(
        'id_ranking'        => $id_ranking,
        'id_top'            => $id_top,
        'url_top'           => get_permalink($id_top)
    )));

}

function delete_real_ranking($id_ranking, $id_vainkeur){

    if(isset($id_ranking) && $id_ranking != ""){

        $id_top             = get_field('id_tournoi_r', $id_ranking);
        $nb_to_decrease  = get_field('nb_votes_r', $id_ranking);
        decrease_user_counter($id_vainkeur, $nb_to_decrease);

        wp_trash_post($id_ranking);

    }

    return die(json_encode( array(
        'id_ranking'        => $id_ranking,
    )));

}