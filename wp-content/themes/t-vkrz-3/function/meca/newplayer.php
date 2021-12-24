<?php
function form_newplayer($emailplayer, $uuiduser, $ranking, $top, $id_vainkeur){

    $user_id = "";

    if(is_user_logged_in()){
        $user_id = get_current_user_id();
    }

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

    // Badge : Top sponso
    if (!get_vainkeur_badge($id_vainkeur, "TOP sponso")) {
        update_vainkeur_badge($id_vainkeur, "TOP sponso");
    }

    vkrz_push_player($emailplayer, $uuiduser, $ranking, $top, $id_vainkeur);

}
