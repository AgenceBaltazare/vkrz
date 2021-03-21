<?php
/*
    Template Name: Delete ranking
*/
if(isset($_GET['confirm']) && $_GET['confirm'] != "ranks") :
    $all_ranking = new WP_Query(array('post_type' => 'classement', 'posts_per_page' => '-1'));
    while ($all_ranking->have_posts()) : $all_ranking->the_post();

        echo get_the_ID();

        wp_delete_post(get_the_ID());

    endwhile;
endif;

if(isset($_GET['confirm']) && $_GET['confirm'] != "votes") :
    $all_votes = new WP_Query(array('post_type' => 'vote', 'posts_per_page' => '-1'));
    while ($all_votes->have_posts()) : $all_votes->the_post();

        wp_delete_post(get_the_ID());

    endwhile;
endif;

if(isset($_GET['confirm']) && $_GET['confirm'] != "all") :

    $all_ranking = new WP_Query(array('post_type' => 'classement', 'posts_per_page' => '-1'));
    while ($all_ranking->have_posts()) : $all_ranking->the_post();

        echo get_the_ID();

        wp_delete_post(get_the_ID());

    endwhile;

    $all_votes = new WP_Query(array('post_type' => 'vote', 'posts_per_page' => '-1'));
    while ($all_votes->have_posts()) : $all_votes->the_post();

        wp_delete_post(get_the_ID());

    endwhile;
endif;
