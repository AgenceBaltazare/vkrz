<?php
function get_tournoi_data($id_tournament, $uuiduser){

    $result                 = array();
    $count_votes_of_t       = 0;
    $list_ranking_of_t      = array();
    $date_of_t              = get_the_date('d F Y', $id_tournament);
    $current_user_have_r    = false;

    $all_ranking_of_t = new WP_Query(array(
        'post_type' => 'classement',
        'orderby' => 'date',
        'order' => 'ASC',
        'posts_per_page' => '-1',
        'ignore_sticky_posts' => true,
        'update_post_meta_cache' => false,
        'no_found_rows' => true,
        'meta_query' => array(
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'nb_votes_r',
                    'value' => 0,
                    'compare' => '>',
                ),
                array(
                    'key' => 'id_tournoi_r',
                    'value' => $id_tournament,
                    'compare' => '=',
                )
            )
        )
    ));
    $c = 1;
    while ($all_ranking_of_t->have_posts()) : $all_ranking_of_t->the_post();

        $count_votes_of_t = $count_votes_of_t + get_field('nb_votes_r');

        if (get_field('uuid_user_r') == $uuiduser) {
            $current_user_have_r = true;
            $current_user_id_ranking = get_the_id();
            $current_user_top3 = get_user_ranking($current_user_id_ranking);
        }

        array_push($list_ranking_of_t, array(
            "id_ranking" => get_the_id(),
            "uuid_user" => get_field('uuid_user_r')
        ));

    endwhile;

    array_push($result, array(
        "date_of_t" => $date_of_t,
        "nb_tops"   => $all_ranking_of_t->post_count,
        "nb_votes"  => $count_votes_of_t
    ));

    return $result;

}

function get_note($id_tournament, $uuiduser){

    $result = array();

    // Get note
    $user_note_of_t = new WP_Query(array(
        'post_type'              => 'note',
        'posts_per_page'         => '1',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'meta_query'             =>
            array(
                'relation' => 'AND',
                array(
                    'key' => 'id_user_n',
                    'value' => $uuiduser,
                    'compare' => '=',
                ),
                array(
                    'key' => 'id_t_n',
                    'value' => $id_tournament,
                    'compare' => '=',
                )
            )
        )
    );
    while ($user_note_of_t->have_posts()) : $user_note_of_t->the_post();

        array_push($result, array(
            "note"      => get_field('id_s_n'),
            "id_note"   => get_the_ID()
        ));

    endwhile;

    wp_reset_postdata();
    wp_reset_query();

    return $result;

}