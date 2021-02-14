<?php
/*
    Template Name: Delete ranking
*/
$all_ranking = new WP_Query(array('post_type' => 'classement', 'posts_per_page' => '-1'));
while ($all_ranking->have_posts()) : $all_ranking->the_post();

    echo get_the_ID();
    wp_delete_post(get_the_ID());

endwhile;
