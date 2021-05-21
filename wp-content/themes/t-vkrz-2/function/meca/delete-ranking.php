<?php

function delete_ranking($id_ranking){

    if(isset($id_ranking) && $id_ranking != ""){

        $id_tournament = get_field('id_tournoi_r', $id_ranking);

        wp_update_post(array(
            'ID'            =>  $id_ranking,
            'post_status'   =>  'draft'
        ));

    }

    return die(json_encode( array(
        'id_ranking'        => $id_ranking,
        'id_tournament'     => $id_tournament,
        'url_tournament'    => get_permalink($id_tournament)
    )));

}