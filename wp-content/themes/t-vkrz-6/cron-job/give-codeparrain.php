<?php
include __DIR__ . '/../../../../wp-load.php';

$user_query = new WP_User_Query(
    array(
        'number' => -1
    )
);
$users = $user_query->get_results();

foreach ($users as $user) {
    
    $user_id = $user->ID;
    $uniquecode = generate_codeparrain($user_id);
    update_field('code_parrain_user', $uniquecode, 'user_' . $user_id);

}
