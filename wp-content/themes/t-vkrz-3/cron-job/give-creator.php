<?php
include __DIR__ . '/../../../../wp-load.php';

$u=1;
$user_query = new WP_User_Query(
    array(
        'number' => -1
    )
);
$users = $user_query->get_results();
foreach ($users as $user) {
    
    $user_id     = $user->ID;
    $uuid_user_r = get_field('uuiduser_user', 'user_'.$user_id);

    $classements = new WP_Query(array(
        'post_type'              => 'classement',
        'posts_per_page'         => -1,
        'fields'                 => 'ids',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'author__not_in'         => array($user_id),
        'meta_query'             => array(
            array(
                'key' => 'uuid_user_r',
                'value' => $uuid_user_r,
                'compare' => '='
            )
        )
    ));
    if ($classements->have_posts()) {
        $r=1; foreach ($classements->posts as $classement) {
            $arg = array(
                'ID'            => $classement,
                'post_author'   => $user_id,
            );

            // Save to firebase & WP
            //wp_update_post($arg);

            echo "U: " . $u . " - R: " . $r. " --> TopList " . $classement . " attribué à " . $user_id . "(" . $uuid_user_r . ")" . "\n";

            $r++;
        }
    }

    $u++;
}