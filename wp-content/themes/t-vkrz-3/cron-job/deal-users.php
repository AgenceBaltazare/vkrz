<?php
include __DIR__ . '/../../../../wp-load.php';

$user_query = new WP_User_Query(array(
    'number'    => -1
));
$users_list = $user_query->get_results();

foreach ($users_list as $user) {

    $user_id        = $user->ID;
    $uuiduser       = get_field('uuiduser_user', 'user_' . $user_id);
    $id_vainkeur    = get_vainkeur_id($uuiduser);

    update_field('id_vainkeur_user', $id_vainkeur, 'user_' . $user_id);
}
