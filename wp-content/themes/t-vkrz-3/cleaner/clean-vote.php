<?php
/*
    Template Name: Clean vote
*/
?>
<?php $all_vote = new WP_Query(array('post_type' => 'vote', 'posts_per_page' => '-1'));
while ($all_vote->have_posts()) : $all_vote->the_post();
    wp_delete_post(get_the_ID(), true );
endwhile; ?>
