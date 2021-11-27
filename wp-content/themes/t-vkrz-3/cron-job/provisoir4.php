<?php
include __DIR__ . '/../../../../wp-load.php';
$player = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'classement',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => -1,
    'meta_query' => array(
        array(
            'key'       => 'id_tournoi_r',
            'value'     => array(279356, 271927, 268679, 237126, 236148, 218860, 188690, 174969, 171780, 154360, 166267, 24453),
            'compare'   => 'IN',
        )
    )
));
while ($player->have_posts()) : $player->the_post();

    $player_uuid = get_field('uuid_user_r');

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
                'key'       => 'uuid_user_vkrz',
                'value'     => $player_uuid,
                'compare'   => '=',
            )
        )
    ));
    while ($vainkeur->have_posts()) : $vainkeur->the_post();

        $id_vainkeur = get_the_ID();

        update_vainkeur_badge($id_vainkeur, 'BIG TOP');

    endwhile;


endwhile;
