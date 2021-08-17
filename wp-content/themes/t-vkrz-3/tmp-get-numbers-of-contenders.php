<?php
include __DIR__.'/../../../wp-load.php';

$tops = new WP_Query(
    array(
        'post_type' => 'tournoi',
        'posts_per_page' => '-1',
        'post_status' => 'publish',
    )
);

if ($tops->have_posts()) {
    foreach($tops->posts as $top) {
        $top_id = $top->ID;

        $contenders = new WP_Query(
            array(
                'post_type'              => 'contender',
                'posts_per_page'         => '-1',
                'fields'                 => 'ids',
                'post_status'            => 'publish',
                'ignore_sticky_posts'    => true,
                'update_post_meta_cache' => false,
                'no_found_rows'          => false,
                'meta_query'     => array(
                    array(
                        'key'     => 'id_tournoi_c',
                        'value'   => $top_id,
                        'compare' => '=',
                    )
                )
            )
        );

        update_field('count_contenders_t', $contenders->post_count, $top_id);
    }
}
