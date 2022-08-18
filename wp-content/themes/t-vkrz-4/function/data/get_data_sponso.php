<?php

function get_players_of_top($id_top){

    $list_of_players = array();
    $list_of_uuid    = array();
    $list_of_rank    = array();
    $vainkeur_logged = 0;

    $all_players_of_t = new WP_Query(
        array(
            'post_type'                 => 'player',
            'posts_per_page'            => '-1',
            'ignore_sticky_posts'       => true,
            'update_post_meta_cache'    => false,
            'no_found_rows'             => true,
            'meta_query' => array(
                array(
                    'key'       => 'id_t_p',
                    'value'     => $id_top,
                    'compare'   => '=',
                )
            )
        )
    );
    while ($all_players_of_t->have_posts()) : $all_players_of_t->the_post();

        array_push($list_of_players, get_field('email_player_p'));
        array_push($list_of_uuid, get_field('uuid_vainkeur_p'));
        array_push($list_of_rank, get_field('id_r_p'));

        $id_vainkeur = get_post_field('post_author', get_the_ID());
        if ($id_vainkeur) {
            $vainkeur_logged++;
        }

    endwhile;

    $list_of_players_unique = array_unique($list_of_players);
    $list_of_uuid_unique    = array_unique($list_of_uuid);
    $list_of_rank_unique    = array_unique($list_of_rank);

    $result = array(
        'nb_players'            => $all_players_of_t->post_count,
        'nb_players_unique'     => count($list_of_players_unique),
        'players_list_mail'     => $list_of_players,
        'players_list_uuid'     => $list_of_uuid_unique,
        'players_list_rank'     => $list_of_rank_unique,
        'vainkeur_logged'       => $vainkeur_logged,
    );

    return $result;

}

function vainkeur_info_by_uuid($players_list_uuid){

    $player_one_top = 0;

    $vainkeur = new WP_Query(
        array(
            'post_type'                 => 'vainkeur',
            'posts_per_page'            => '-1',
            'ignore_sticky_posts'       => true,
            'update_post_meta_cache'    => false,
            'no_found_rows'             => true,
            'meta_query' => array(
                array(
                    'key'       => 'uuid_user_vkrz',
                    'value'     => $players_list_uuid,
                    'compare'   => 'IN',
                )
            )
        )
    );
    while ($vainkeur->have_posts()) : $vainkeur->the_post();

        $nb_top = get_field('nb_top_vkrz');
        if ($nb_top <= 1) {
            $player_one_top++;
        }

    endwhile;

    $one_top_percent = $player_one_top * 100 / ($vainkeur->post_count);

    $result = array(
        'player_one_top'        => $player_one_top,
        'one_top_percent'       => $one_top_percent
    );

    return $result;

}