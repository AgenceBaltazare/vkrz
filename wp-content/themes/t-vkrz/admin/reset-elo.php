<?php
/*
    Template Name: Reset ELO
*/
$confirm = $_GET['confirm'];
if($confirm == "go"){
    $all_contenders = new WP_Query(array('post_type' => 'contender', 'posts_per_page' => '-1'));
    while ($all_contenders->have_posts()) : $all_contenders->the_post();
        update_field('ELO_c', 1200);
    endwhile;
}
