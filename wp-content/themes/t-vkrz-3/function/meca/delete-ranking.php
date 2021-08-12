<?php
function delete_ranking($id_ranking){

    if(isset($id_ranking) && $id_ranking != ""){

        $id_top = get_field('id_tournoi_r', $id_ranking);

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

function delete_real_ranking($id_ranking){

    if(isset($id_ranking) && $id_ranking != ""){

        wp_trash_post($id_ranking);

    }

    return die(json_encode( array(
        'id_ranking'        => $id_ranking,
    )));

}