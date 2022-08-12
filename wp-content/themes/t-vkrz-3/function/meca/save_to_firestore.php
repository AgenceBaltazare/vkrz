<?php 
function save_to_firestore($id_top, $current_id_vainkeur, $id_ranking){
    
    $id_resume = get_resume_id($id_top);
    wp_update_post(array('ID' => $id_ranking));
    wp_update_post(array('ID' => $current_id_vainkeur));
    wp_update_post(array('ID' => $id_resume));

    update_field('maj_vkrz', 'testfirestore', $current_id_vainkeur);

    $result = array(
        'Top' => $id_top,
        'Vainkeur' => $current_id_vainkeur,
        'Resume' => $id_resume,
        'TopList' => $id_resume,
    );

    return json_encode($result);
}