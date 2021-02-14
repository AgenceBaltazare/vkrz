<?php
/*
    Template Name: Delete votes
*/
$all_ranking = new WP_Query(array('post_type' => 'vote', 'posts_per_page' => '-1'));
while ($all_ranking->have_posts()) : $all_ranking->the_post();

    wp_delete_post(get_the_ID());

endwhile;
