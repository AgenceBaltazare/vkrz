<?php
/*
        Template Name: Convert top
    */
?>
<?php
$all_tops = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'tournoi',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => -1
));
while ($all_tops->have_posts()) : $all_tops->the_post();

    wp_set_post_terms( get_the_ID(), 'classik', 'type');

endwhile; ?>