<?php 
function save_to_firestore($id_top, $current_id_vainkeur, $id_ranking){
    
    $id_resume = get_resume_id($id_top);
    wp_update_post(array('ID' => $id_ranking));
    wp_update_post(array('ID' => $current_id_vainkeur));
    wp_update_post(array('ID' => $id_resume));

}

function save_elo_to_firestore($contender1, $contender2){

    wp_update_post(array('ID' => $contender1));
    wp_update_post(array('ID' => $contender2));

}