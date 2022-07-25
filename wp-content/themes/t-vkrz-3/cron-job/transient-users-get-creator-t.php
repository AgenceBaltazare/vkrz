<?php
include __DIR__.'/../../../../wp-load.php';

/**
 * CRON JOB : Update transient "user_id_get_creator_t" for all creators users
 *
 * When : Everyday @ 00:00
 */

// user_role == author or administrator
$user_query = new WP_User_Query(
    array(
        'number' => -1,
        'role__in' => array('administrator', 'author')
    )
);
$users = $user_query->get_results();

foreach($users as $user){
    $user_id = $user->ID;

    delete_transient( 'user_'.$user_id.'_get_creator_t' );

    $data_t_created = get_creator_t($user_id);
    set_transient( 'user_'.$user_id.'_get_creator_t', $data_t_created, DAY_IN_SECONDS );
}
