<?php
include __DIR__.'/../../../../wp-load.php';

/**
 * CRON JOB : Update transient "user_id_get_user_tops" and "user_id_deal_vainkeur_entry" for all users
 *
 * When : Everyday @ 00:00
 */

$user_query = new WP_User_Query(array(
     'number' => -1
 ));
$users_list = $user_query->get_results();

foreach($users_list as $user){
 $user_id = $user->ID;

 delete_transient( 'user_'.$user_id.'_get_user_tops' );
 delete_transient( 'user_'.$user_id.'_deal_vainkeur_entry' );

 $user_tops = get_user_tops($user_id);
 set_transient( 'user_'.$user_id.'_get_user_tops', $user_tops, DAY_IN_SECONDS );

 $user_infos = deal_vainkeur_entry($user_id);
 set_transient( 'user_'.$user_id.'_deal_vainkeur_entry', $user_infos, DAY_IN_SECONDS );

}
