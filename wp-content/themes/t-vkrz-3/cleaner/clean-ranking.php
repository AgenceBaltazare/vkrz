<?php
/*
    Template Name: Clean ranking
*/
?>
<?php $all_vote = new WP_Query(array('post_type' => 'classement', 'post_status' => 'any', 'posts_per_page' => '-1'));
while ($all_vote->have_posts()) : $all_vote->the_post();
    if(get_field('nb_votes_r') == 0){
        wp_delete_post(get_the_ID(), true );
    }
endwhile; ?>
