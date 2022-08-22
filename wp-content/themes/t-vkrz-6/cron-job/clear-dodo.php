<?php
include __DIR__ . '/../../../../wp-load.php';

$dodo = new WP_Query(array(
    'ignore_sticky_posts'	=> true,
    'update_post_meta_cache' => false,
    'no_found_rows'		  => true,
    'post_type'			  => 'vainkeur',
    'orderby'				=> 'date',
    'order'				  => 'DESC',
    'posts_per_page'		 => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'badges',
            'field'    => 'slug',
            'terms'    => array('dodo'),
            'operator' => 'IN'
        ),
    )
    )
);
while ($dodo->have_posts()) : $dodo->the_post();

    $id_vainkeur  = get_the_ID();
    $author_id    = get_post_field("post_author", $id_vainkeur);
    $user_info    = get_userdata($author_id);
    $user_pseudo  = $user_info->user_nicename;

    $get_money    = get_field('money_vkrz', $id_vainkeur);
    $get_dispo    = get_field('money_disponible_vkrz', $id_vainkeur);

    //update_field('money_vkrz', $get_money - 300, $id_vainkeur);
    //update_field('money_disponible_vkrz', $get_dispo - 300, $id_vainkeur);

    echo $user_pseudo . " - " . get_the_ID() . " Money : " . $get_money . " Dispo : " . $get_dispo . "<br>";

endwhile; wp_reset_query();
