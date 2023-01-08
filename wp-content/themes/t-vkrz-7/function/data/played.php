<?php
function already_play($uuiduser, $id_top){

    $players = new WP_Query(array(
        'post_type'         => 'player',
        'posts_per_page'    => '-1',
        'meta_query'        => array(
            'relation' => 'AND',
            array(
                'key'     => 'uuid_vainkeur_p',
                'value'   => $uuiduser,
                'compare' => '=',
            ),
            array(
                'key'     => 'id_t_p',
                'value'   => $id_top,
                'compare' => '=',
            )
        )
    ));

    if ($players->have_posts()) {
        return true;
    }
    else{
        return false;
    }

}