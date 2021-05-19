<?php
/**
 * Créer un classement pour associer à l'utilisateur et au tournoi si il n'existe pas
 *
 * @param int $id_tournament
 *
 * @return bool|false|int|WP_Error $id_classment_user
 */
function get_or_create_ranking_if_not_exists($id_tournament) {

    $uuiduser = $_COOKIE['vainkeurz_user_id'];

    if(isset($uuiduser) && $uuiduser != ""){

        // Get user ranking
        $user_ranking = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'posts_per_page' => '1', 'meta_query' =>
            array(
                'relation'  => 'AND',
                array(
                    'key'     => 'id_tournoi_r',
                    'value'   => $id_tournament,
                    'compare' => '=',
                ),
                array(
                    'key' => 'uuid_user_r',
                    'value' => $uuiduser,
                    'compare' => '=',
                )
            )
        ));
        if($user_ranking->have_posts()){
            while ($user_ranking->have_posts()) : $user_ranking->the_post();
                $id_ranking = get_the_ID();
            endwhile;
        }
        else{
            $new_ranking = array(
                'post_type'   => 'classement',
                'post_title'  => 'T:' . $id_tournament .' U:' . $uuiduser,
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

            update_field('uuid_user_r', $uuiduser, $id_ranking);
            update_field('id_tournoi_r', $id_tournament, $id_ranking);
            update_field("ranking_r", $list_contenders, $id_ranking);
            update_field('nb_votes_r', 0, $id_ranking);
            update_field('timeline_main', 1, $id_ranking);
            update_field('timeline_2', 0, $id_ranking);
            update_field('timeline_4', 0, $id_ranking);
            update_field('timeline_5', 0, $id_ranking);

        }

        return $id_ranking;

    }
    else{

        return "Erreur 801 : Impossible de créer un classement";

    }

}
?>