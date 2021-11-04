<?php
function form_newplayer($emailplayer, $uuiduser, $ranking, $top){

    $user_id = "";

    if(is_user_logged_in()){
        $user_id = get_current_user_id();
    }

    $url    = "https://hook.integromat.com/puo4c27s2ygviafkqhwrpydbx6klwlym";
    $args   = array(
        'body' => array(
            'email'             => $emailplayer,
            'sponsor'           => get_field('nom_de_la_sponso_t_sponso', $top),
            'date'              => date('Y-m-d H:i:s'),
            'id_ranking'        => $ranking,
            'uuiduser'          => $uuiduser,
            'id_top'            => $top,
        )
    );
    wp_remote_post($url, $args);

    $new_player = array(
        'post_type'   => 'player',
        'post_title'  => 'U:' . $uuiduser . ' T:' . $top . ' R:' . $ranking,
        'post_status' => 'publish',
        'post_author' => $user_id
    );
    $id_new_player  = wp_insert_post($new_player);

    update_field('uuid_vainkeur_p', $uuiduser, $id_new_player);
    update_field('id_t_p', $top, $id_new_player);
    update_field('id_r_p', $ranking, $id_new_player);
    update_field('email_player_p', $emailplayer, $id_new_player);

}
