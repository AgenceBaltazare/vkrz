<?php 
function save_to_firestore($id_top, $current_id_vainkeur, $id_ranking){
    
    $id_resume = get_resume_id($id_top);
    wp_update_post($id_ranking);
    wp_update_post($current_id_vainkeur);
    wp_update_post($id_resume);

}

function save_elo_to_firestore($contender_1, $contender_2){

    wp_update_post($contender_1);
    wp_update_post($contender_2);
    
}