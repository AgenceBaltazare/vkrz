<?php

include __DIR__.'/../../../wp-load.php';

$user_query = new WP_User_Query(array(
    'number' => -1
));
$users_list = $user_query->get_results();

foreach($users_list as $user){
    $user_id = $user->ID;
    $uuid = get_field('uuiduser_user', 'user_'.$user_id);

    $user_all_ranking = new WP_Query(array(
        'post_type'              => 'vainkeur',
        'posts_per_page'         => '-1',
        'fields'                 => 'ids',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'author__not_in'         => array($user_id),
        'meta_query'             => array(array(
            'key' => 'uuid_user_vkrz',
            'value' => $uuid,
            'compare' => '='
        )),
    ));

    if ($user_all_ranking->have_posts()) {
        foreach ($user_all_ranking->posts as $classement) {
            $arg = array(
                'ID' => $classement,
                'post_author' => $user_id,
            );
            wp_update_post( $arg );
        }
    }

}