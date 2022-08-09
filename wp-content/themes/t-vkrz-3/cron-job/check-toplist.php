<?php
include __DIR__ . '/../../../../wp-load.php';

$classements = new WP_Query(array(
    'post_type'              => 'classement',
    'posts_per_page'         => -1,
    'fields'                 => 'ids',
    'post_status'            => 'publish',
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => false,
    'meta_query'             => array(
        array(
            'key' => 'id_vainkeur_r',
            'compare' => 'NOT EXISTS'
        )
    )
));
if ($classements->have_posts()) {
    foreach ($classements->posts as $classement) {
        echo "TopList " . $classement . "\n";
    }
}
