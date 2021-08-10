<?php
include __DIR__.'/../../../../wp-load.php';

/**
 * CRON JOB : Update transient "user_id_get_user_full_data" for all users
 *
 * When : Everyday @ 00:00
 */

 $user_query = new WP_User_Query(array(
         'number' => -1
     ));
 $users_list = $user_query->get_results();

 foreach($users_list as $user){
     $user_id = $user->ID;

     delete_transient( 'user_'.$user_id.'_get_user_full_data' );

     $user_full_data = get_user_full_data($user_id, "author");
     set_transient( 'user_'.$user_id.'_get_user_full_data', $user_full_data, DAY_IN_SECONDS );
 }