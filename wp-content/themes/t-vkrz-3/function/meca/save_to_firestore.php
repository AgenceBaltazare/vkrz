<?php 
function save_to_firestore($id_top, $id_vainkeur, $id_ranking){
    
    $id_resume = get_resume_id($id_top);
    wp_update_post(array('ID' => $id_ranking));
    wp_update_post(array('ID' => $id_vainkeur));
    wp_update_post(array('ID' => $id_resume));

}

function save_elo_to_firestore($contender_1, $contender_2){

    //wp_update_post(array('ID' => $contender_1));
    //wp_update_post(array('ID' => $contender_2));

    $post_id = '471001';
    $data = new stdClass();

    $data->custom_fields = new stdClass();
    $data->custom_fields->ELO_c = 'test';

    error_log(print_r($data));

    // { 
    //     custom_fields: {
    //        ELO_c: 'test'
    //     }
    //  }
    

    apply_filters('firebase_save_data_to_database', 'firestore', 'wpContender', $post_id, $data);
}

function save_elo_to_firestore_delete($id_ranking, $id_vainkeur){

    $id_top     = get_field('id_tournoi_r', $id_ranking);
    $id_resume  = get_resume_id($id_top);
    wp_update_post(array('ID' => $id_resume));
    wp_update_post(array('ID' => $id_vainkeur));

    update_field('maj_vkrz', $id_resume, 209404);
    
}