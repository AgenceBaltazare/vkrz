<?php
include __DIR__ . '/../../../../wp-load.php';

$classements = new WP_Query(array(
    'post_type'              => 'classement',
    'posts_per_page'         => 200,
    'fields'                 => 'ids',
    'post_status'            => 'publish',
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => false,
    'orderby'                => 'date',
    'order'                  => 'DESC',
));
if ($classements->have_posts()) {
    $i=1; foreach ($classements->posts as $classement) {

        
        echo $i . " -> TopList : " . $classement . " titre : " . get_the_title($classement) . "\n";
        wp_update_post(array('ID' => $classement));

        $i++;
    }
}
