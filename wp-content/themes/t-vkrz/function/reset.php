<?php
/*
    Template Name: Reset
*/
?>
<?php

if($_GET['pass'] == "vkrz"){

    $all_contenders = new WP_Query(array('post_type' => 'contender', 'orderby' => 'date', 'posts_per_page' => '-1'));
    while ($all_contenders->have_posts()) : $all_contenders->the_post();

        update_field('ELO_c', '1200', get_the_ID());

    endwhile;
}
