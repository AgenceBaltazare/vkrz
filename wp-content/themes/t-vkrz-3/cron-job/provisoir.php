<?php
/*
        Template Name: Provisoir player
    */
include __DIR__ . '/../../../../wp-load.php';
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

    if(get_field('nb_top_vkrz') >= 1){
        update_vainkeur_badge($id_vainkeur, '1 000 votes');
    }

endwhile; ?>