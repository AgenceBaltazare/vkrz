<?php
include __DIR__.'/../../../../wp-load.php';

/**
 * CRON JOB : Update transient "best_tops_of_all_time"
 *
 * When : Everyday @ 02:00
 */

$rankings = new WP_Query(
    array(
        'post_type'              => 'classement',
        'posts_per_page'         => '50000',
        'fields'                 => 'ids',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'meta_query' => array(
            array(
                'key' => 'done_r',
                'value' => 'done',
                'compare' => '=',
            )
        )
    )
);

$best_tops = best_tops($rankings);

if (!empty(get_transient( 'best_tops_of_all_time' ))) {
    delete_transient( 'best_tops_of_all_time' );
}
set_transient( 'best_tops_of_all_time', $best_tops, DAY_IN_SECONDS );
