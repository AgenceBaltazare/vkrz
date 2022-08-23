<?php
include __DIR__ . '/../../../../wp-load.php';

$classements = new WP_Query(array(
    'post_type'              => 'classement',
    'posts_per_page'         => 200,
    'fields'                 => 'ids',
    'post_status'            => 'publish',
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => false,
    'orderby'                => 'date',
    'order'                  => 'DESC',
));
if ($classements->have_posts()) {

    $array_vainkeur = array();
    $array_resume   = array();
    $i=1; $r=1; foreach ($classements->posts as $classement) {

        $id_vainkeur = get_field('id_vainkeur_r', $classement);
        $id_top      = get_field('id_tournoi_r', $classement);
        $id_resume   = get_resume_id($id_top);

        array_push($array_vainkeur, $id_vainkeur);
        if(!in_array($id_vainkeur, $array_vainkeur)){
            //wp_update_post(array('ID' => $id_vainkeur));
            echo $i . " VAINKEUR : " . $id_vainkeur . "\n";
        }

        array_push($array_resume, $id_resume);
        if (!in_array($id_resume, $array_resume)) {
            //wp_update_post(array('ID' => $id_resume));
            echo $r . " Resume : " . $id_resume . "\n";
        }

        //echo $i . " -> TopList : " . $classement . " titre : " . get_the_title($classement) . "\n";

        $i++;
        $r++;
    }
}
