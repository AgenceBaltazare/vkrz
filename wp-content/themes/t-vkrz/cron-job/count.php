<?php
include __DIR__ . '/../../../../wp-load.php';

$classement = new WP_Query(
    array(
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'post_type'              => 'classement',
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'posts_per_page'         => 10,
        'date_query'     => array(
            'after' => array(
                'year'  => 2020,
                'month' => 5,
                'day'   => 1,
            )
        )
    )
);
$nb_votes   = 0;
$nb_tops    = 0;
while ($classement->have_posts()) : $classement->the_post();

    $id_ranking   = get_the_ID();
    $nb_vote      = get_field('nb_votes_r', $id_ranking);

    $nb_votes     = $nb_votes + $nb_vote;

    echo $id_ranking . " - Votes : " . $nb_vote . "\n<br>";

    $nb_tops++;

endwhile;
wp_reset_query();

//echo "\n\n Résultat : " . $nb_tops . " " . $nb_votes;
