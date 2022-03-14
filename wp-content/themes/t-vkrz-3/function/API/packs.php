<?php
require_once('fct.php');


function get_single_ranking($data){

    $list_ranking      = "";
    $id_ranking        = $data['id_ranking'];
    $user_ranking      = get_user_ranking($id_ranking);
    $total_rank        = array();

    $i=1;
    foreach ($user_ranking as $c) :

        $list_ranking .= get_the_title($c) . " ";

    $i++;
    endforeach;

    array_push($total_rank, array(
        "classement" => $list_ranking,
    ));
        
    return $list_ranking;
}

function add_contender_from_api(){
    
    $id_visual   = $_GET['idphoto'];
    $url_visual  = $_GET['url_visual'];
    $pseudo      = $_GET['pseudo'];
    $id_top      = $_GET['id_top'];

    if ($id_visual) {

        $new_contender = array(
            'post_type'   => 'contender',
            'post_title'  => $pseudo,
            'post_status' => 'publish',
        );
        $id_new_contender  = wp_insert_post($new_contender);

        update_field('visuel_instagram_contender', $url_visual, $id_new_contender);
        update_field('id_tournoi_c', $id_top, $id_new_contender);
        update_field('ELO_c', '1200', $id_new_contender);

        if($id_new_contender){
            return "Nouveau contender dans le Top ".get_the_title($id_top);
        }
    }
}