<?php
include __DIR__.'/../../../../wp-load.php';

/**
 * CRON JOB : Update transient "user_id_get_user_tops" for all users
 *
 * When : Everyday @ 00:00
 */

$user_query = new WP_User_Query(array(
    'number' => -1
));
$users_list = $user_query->get_results();

foreach($users_list as $user){
    
    $user_id = $user->ID;
    $id_vainkeur    = get_field('id_vainkeur_user', 'user_' . $user_id);
    
    $user_tops      = get_user_tops($id_vainkeur);
    set_transient( 'user_'.$user_id.'_get_user_tops', $user_tops, DAY_IN_SECONDS );

}
