<?php


function form_newplayer($emailplayer, $uuiduser, $ranking, $top, $id_vainkeur){
    
    $mailcontent = get_field('message_email_t_sponso', $top);
    
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
    

    if (env()) {
        $url    = "https://hook.eu1.make.com/u842gfb48zjijv3b7cvih8v1jwphp254";
        $args   = array(
            'body' => array(
                'email_player' => $emailplayer,
                'id_vainkeurz' => $id_vainkeur,
                'id_top' => $top,
                'id_ranking' => $ranking,
                'mail_content' => $mailcontent,
                            )
                        );
            
            wp_remote_post($url, $args);
        }
    
}
