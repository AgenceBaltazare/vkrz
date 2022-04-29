<?php
function do_notification($uuiduser, $notif_text){

    $new_notification = array(
        'post_type'   => 'notification',
        'post_title'  => 'Nouveau follow',
        'post_status' => 'publish',
    );
    $id_new_notification  = wp_insert_post($new_notification);

    update_field('uuid_user_notif', $uuiduser, $id_new_notification);
    update_field('texte_notif', $notif_text, $id_new_notification);
    update_field('statut_notif', 'nouveau', $id_new_notification);

    return die(json_encode($id_new_notification));
    
}
