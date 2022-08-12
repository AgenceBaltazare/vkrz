<?php 
function save_to_firestore($id_top, $current_id_vainkeur, $id_ranking){
    
    $id_resume = get_resume_id($id_top);
    wp_update_post($id_ranking);
    wp_update_post($current_id_vainkeur);
    wp_update_post($id_resume);

    update_field('maj_vkrz', 'fdfd', 469420);

}

function save_elo_to_firestore($contender1, $contender2){

    wp_update_post($contender1);
    wp_update_post($contender2);

    update_field('maj_vkrz', 'wa', 469396);
    
}