<?php
/*
        Template Name: Badge Top sponso
    */
include __DIR__ . '/../../../../wp-load.php';
?>

<?php
$player = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'player',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => -1
));
while ($player->have_posts()) : $player->the_post();

    $player_uuid = get_field('uuid_vainkeur_p');

    $vainkeur = new WP_Query(array(
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'post_type'              => 'vainkeur',
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'posts_per_page'         => 30000,
        'meta_query' => array(
            array(
                'key'       => 'uuid_user_vkrz',
                'value'     => $player_uuid,
                'compare'   => '=',
            )
        )
    ));
    while ($vainkeur->have_posts()) : $vainkeur->the_post();

        $id_vainkeur = get_the_ID();

        update_vainkeur_badge($id_vainkeur, 'TOP sponso');

    endwhile;


endwhile;

?>