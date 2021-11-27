<?php
/*
        Template Name: Provisoir player
    */
?>
<?php
$vainkeur = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'vainkeur',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => 30000
));
while ($vainkeur->have_posts()) : $vainkeur->the_post();

    $id_vainkeur = get_the_ID();

    if(get_field('nb_vote_vkrz') >= 1000){
        update_vainkeur_badge($id_vainkeur, '1 000 votes');
    }
    if (get_field('nb_vote_vkrz') >= 10000) {
        update_vainkeur_badge($id_vainkeur, '10 000 votes');
    }
    if (get_field('nb_vote_vkrz') >= 100000) {
        update_vainkeur_badge($id_vainkeur, '100 000 votes');
    }

endwhile; ?>