<?php
include __DIR__ . '/../../../../wp-load.php';

$vainkeur = new WP_Query(
    array(
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'post_type'              => 'vainkeur',
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'posts_per_page'         => -1,
        'meta_query' => array(
            array(
                'key'     => 'nb_vote_vkrz',
                'value'   => '10000',
                'compare' => '>=',
            ),
        ),
    )
);
while ($vainkeur->have_posts()) : $vainkeur->the_post();

    $id_vainkeur  = get_the_ID();
    $author_id    = get_post_field("post_author", $id_vainkeur);
    $user_info    = get_userdata($author_id);
    $user_pseudo  = $user_info->user_nicename;

    $nb_vote      = get_field('nb_vote_vkrz', $id_vainkeur);

    echo $user_pseudo . " - " . get_the_ID() . " Votes : " . $nb_vote . "<br>";

endwhile;
wp_reset_query();
