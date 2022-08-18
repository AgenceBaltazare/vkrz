<?php
function get_similar_ranking($uuiduser, $id_top){

    $list_ranking_of_t      = array();
    $count_same_ranking     = 0;

    $all_ranking_of_t       = new WP_Query(array(
        'post_type'                 => 'classement',
        'posts_per_page'            => '-1',
        'ignore_sticky_posts'       => true,
        'update_post_meta_cache'    => false,
        'no_found_rows'             => true,
        'meta_query'                => array(
            'relation' => 'AND',
            array(
                'key'       => 'done_r',
                'value'     => 'done',
                'compare'   => '=',
            ),
            array(
                'key'       => 'id_tournoi_r',
                'value'     => $id_top,
                'compare'   => '=',
            )
        )
    ));

    while ($all_ranking_of_t->have_posts()) : $all_ranking_of_t->the_post();

        if(get_field('uuid_user_r') == $uuiduser){
            $current_user_id_ranking = get_the_id();
            $current_user_top3       = get_user_ranking($current_user_id_ranking, 3);
        }

        if(get_field('uuid_user_r') != $uuiduser) {
            array_push($list_ranking_of_t, array(
                "id_ranking" => get_the_id(),
                "uuid_user"  => get_field('uuid_user_r')
            ));
        }

    endwhile;

    foreach($list_ranking_of_t as $rank){

        if(get_user_ranking($rank['id_ranking'], 3) == $current_user_top3){
            $count_same_ranking++;
        }

    }

    $nb_tops = $all_ranking_of_t->post_count;

    if ($nb_tops === 0){
        $percent = 0;
    }else{
        $percent = round($count_same_ranking * 100 / ($nb_tops - 1));
    }
    $all_ranking_of_t->reset_postdata();

    wp_reset_query();

    return die(json_encode(array(
        "percent"    => $percent,
        "nb_similar" => $count_same_ranking,
    )));
}