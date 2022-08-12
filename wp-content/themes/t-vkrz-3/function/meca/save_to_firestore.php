<?php 
function save_to_firestore($id_top, $current_id_vainkeur, $id_ranking){
    
    $id_resume = get_resume_id($id_top);
    wp_update_post(array('ID' => $id_ranking));
    wp_update_post(array('ID' => $current_id_vainkeur));
    wp_update_post(array('ID' => $id_resume));

    update_field('maj_vkrz', $id_ranking, 469420);

}

function save_elo_to_firestore($contender_1, $contender_2){

    wp_update_post(array('ID' => $contender_1));
    wp_update_post(array('ID' => $contender_2));

    update_field('maj_vkrz', $contender_1, 469396);
    
}