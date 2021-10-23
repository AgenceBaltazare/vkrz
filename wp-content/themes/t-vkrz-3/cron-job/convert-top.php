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
    'post_type'              => 'classement',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'type',
            'field'    => 'slug',
            'terms'    => array('classik', 'private'),
            'operator' => 'NOT IN'
        ),
    )
));
while ($all_tops->have_posts()) : $all_tops->the_post();

    $id_rank = get_the_ID();
    $id_top = get_field('id_tournoi_r', );
    
    if(get_field('sponso_t', $id_top)){
        wp_set_post_terms($id_rank, 'sponso', 'type');
    } elseif (get_field('private_t', $id_top)) {
        wp_set_post_terms($id_rank, 'private', 'type');
    } elseif (get_field('marqueblanche_t', $id_top)) {
        wp_set_post_terms($id_rank, 'whitelabel', 'type');
    } else{
        wp_set_post_terms($id_rank, 'classik', 'type');
    }

endwhile; ?>