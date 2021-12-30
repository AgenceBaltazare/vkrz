<?php
include __DIR__ . '/../../../../wp-load.php';
$vainkeur = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'vainkeur',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => -1,
    'meta_query' => array(
        array(
            'key'       => 'nb_top_vkrz',
            'value'     => 1,
            'compare'   => '>=',
        )
    )
));
while ($vainkeur->have_posts()) : $vainkeur->the_post();

    $id_vainkeur = get_the_ID();
    $nb_votes    = get_field('nb_vote_vkrz');
    $money       = get_field('money_vkrz');

    if($nb_votes >= 1000){
        update_vainkeur_badge($id_vainkeur, '1 000 votes');
    }
    else{
        wp_remove_object_terms($id_vainkeur, array('1 000 votes'), 'badges');
        $new_money = $money - 100;
        update_field('money_vkrz', $new_money, $id_vainkeur);
    }

endwhile; ?>