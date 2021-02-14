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
            $id_new_classement = get_the_ID();
        endwhile;
    }
    else{
        $new_classement = array(
            'post_type'   => 'classement',
            'post_title'  => 'T:' . $id_tournoi .' U:' . $uuiduser,
            'post_status' => 'publish',
        );
        $id_new_classement  = wp_insert_post($new_classement);
        update_field('uuid_user_r', $uuiduser, $id_new_classement);
        update_field('id_tournoi_r', $id_tournoi, $id_new_classement);
    }

    return $id_new_classement;

}