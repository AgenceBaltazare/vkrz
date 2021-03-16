<?php

function get_user_ranking($uuiduser, $id_tournoi){

    // Classement perso - ID
    $classement_perso = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'posts_per_page' => '1', 'meta_query' =>
        array(
            'relation'  => 'AND',
            array(
                'key'     => 'id_tournoi_r',
                'value'   => $id_tournoi,
                'compare' => '=',
            ),
            array(
                'key' => 'uuid_user_r',
                'value' => $uuiduser,
                'compare' => '=',
            )
        )
    ));
    if($classement_perso->have_posts()){
        while ($classement_perso->have_posts()) : $classement_perso->the_post();
            $id_ranking = get_the_ID();
        endwhile;
    }
    else{
        $new_classement = array(
            'post_type'   => 'classement',
            'post_title'  => 'T:' . $id_tournoi .' U:' . $uuiduser,
            'post_status' => 'publish',
        );
        $id_ranking  = wp_insert_post($new_classement);

        $contenders = new WP_Query(
            array(
                'post_type'      => 'contender',
                'posts_per_page' => -1,
                'meta_key'       => 'ELO_c',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
                'meta_query'     => array(
                    array(
                        'key'     => 'id_tournoi_c',
                        'value'   => $id_tournoi,
                        'compare' => 'LIKE',
                    )
                )
            )
        );

        $i=0; while ($contenders->have_posts()) : $contenders->the_post();

            array_push($list_contenders, array(
                "id"                => $i,
                "id_global"         => get_the_ID(),
                "elo"               => get_field('ELO_c'),
                "contender_name"    => get_the_title(),
                "vote"              => 0,
                "superieur_to"      => array(),
                "inferior_to"       => array(),
                "place"             => 0
            ));

        $i++; endwhile;

        update_field('uuid_user_r', $uuiduser, $id_ranking);
        update_field('id_tournoi_r', $id_tournoi, $id_ranking);
        update_field("ranking_r", $list_contenders, $id_ranking);

    }

    return $id_ranking;

}