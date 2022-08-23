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
    'date_query' => array(
        array(
            'column' => 'post_date_gmt',
            'before' => '1 day ago',
        ),
    ),
));
if ($classements->have_posts()) {
    $i=1; foreach ($classements->posts as $classement) {

        echo $i . " -> TopList " . $classement . "\n";

        $i++;
    }
}
