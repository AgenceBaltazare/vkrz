<?php
function begin_t($id_tournament, $uuiduser, $typetop){

    global $utm;

    if(!$utm){
        $utm = $_COOKIE['vainkeurz_user_utm'];
    }

    if($typetop == "top3"){
        $title_rank = 'Podium '.get_the_title($id_tournament);
    }
    else{
        $title_rank = 'Top '.get_numbers_of_contenders($id_tournament).' - '.get_the_title($id_tournament);
    }

    $new_ranking = array(
        'post_type'   => 'classement',
        'post_title'  => $title_rank,
        'post_status' => 'publish',
    );
    $id_ranking  = wp_insert_post($new_ranking);

    $list_contenders = array();

    $contenders = new WP_Query(
        array(
            'post_type'      => 'contender',
            'posts_per_page' => -1,
            'meta_key'       => 'ELO_c',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'no_found_rows'          => true,
            'meta_query'     => array(
                array(
                    'key'     => 'id_tournoi_c',
                    'value'   => $id_tournament,
                    'compare' => '=',
                )
            )
        )
    );
    $i=0; while ($contenders->have_posts()) : $contenders->the_post();

        array_push($list_contenders, array(
            "id"                => $i,
            "id_wp"             => get_the_ID(),
            "elo"               => get_field('ELO_c'),
            "c_name"            => get_the_title(),
            "more_to"           => array(),
            "less_to"           => array(),
            "place"             => 0,
            "ratio"             => 0,
        ));

    $i++; endwhile;

    update_field('type_top_r', $typetop, $id_ranking);
    update_field('uuid_user_r', $uuiduser, $id_ranking);
    update_field('id_tournoi_r', $id_tournament, $id_ranking);
    update_field('ranking_r', $list_contenders, $id_ranking);
    update_field('nb_votes_r', 0, $id_ranking);
    update_field('timeline_main', 1, $id_ranking);
    update_field('timeline_2', 0, $id_ranking);
    update_field('timeline_4', 0, $id_ranking);
    update_field('timeline_5', 0, $id_ranking);
    update_field('utm_campaign_r', $utm, $id_ranking);

    return $id_ranking;

}