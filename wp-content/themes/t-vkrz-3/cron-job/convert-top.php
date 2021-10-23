<?php
/*
        Template Name: Convert top
    */
?>
<?php
$all_classement = new WP_Query(array(
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
            'terms'    => array('private')
        ),
    ),
));
echo $all_classement->post_count;
while ($all_classement->have_posts()) : $all_classement->the_post();

    $id_rank = get_the_ID();
    $id_top  = get_field('id_tournoi_r', $id_rank);

    if ($id_top == 192381) {
        wp_set_post_terms($id_rank, 'sponso', 'type');
    }

endwhile;

?>