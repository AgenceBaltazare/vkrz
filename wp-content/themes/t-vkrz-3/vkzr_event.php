<?php
    /*
        Template Name: vkzr_event
    */
?>
<?php
$vkzr_event = new WP_Query(array(
    'ignore_sticky_posts'	=> true,
    'update_post_meta_cache' => false,
    'no_found_rows'		  => true,
    'post_type'			  => 'vkzr_event',
    'orderby'				=> 'date',
    'order'				  => 'DESC',
    'posts_per_page'		 => -1
));
while ($vkzr_event->have_posts()) : $vkzr_event->the_post(); ?>

    <?php the_title(); ?>

<?php endwhile; wp_reset_query(); ?>

<h1><?php echo $vkzr_event->post_count; ?></h1>