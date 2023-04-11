<?php
function delete_real_ranking($id_ranking, $id_vainkeur){

    if(isset($id_ranking) && $id_ranking != ""){

        $id_top             = get_field('id_tournoi_r', $id_ranking);
        
        decrease_user_counter($id_vainkeur, $id_ranking);
        increase_top_resume($id_ranking, 'again');

        // Mise à jour de la liste des TopList du Vainkeur
        if(get_field('liste_des_toplist_vkrz', $id_vainkeur)){
            $user_list_toplist = json_decode(get_field('liste_des_toplist_vkrz', $id_vainkeur));
            $user_list_toplist = array_diff($user_list_toplist, array($id_ranking));
            $user_list_toplist = '[' . implode(',', $user_list_toplist) . "]";
            update_field('liste_des_toplist_vkrz', $user_list_toplist, $id_vainkeur);
        }

        // Mise à jour de la liste des Tops terminés du Vainkeur
        if (get_field('liste_des_top_vkrz', $id_vainkeur)) {
            $user_list_top = json_decode(get_field('liste_des_top_vkrz', $id_vainkeur));
            $user_list_top = array_diff($user_list_top, array($id_top));
            $user_list_top = '['. implode(',', $user_list_top). "]";
            update_field('liste_des_top_vkrz', $user_list_top, $id_vainkeur);
        }

        // Suppression du Top dans la liste des Tops commencé du Vainkeur
        if (get_field('liste_des_top_commences_vkrz', $id_vainkeur)) {
            $user_list_top_begin = json_decode(get_field('liste_des_top_commences_vkrz', $id_vainkeur));
            $user_list_top_begin = array_diff($user_list_top_begin, array($id_top));
            $user_list_top_begin = '[' . implode(',', $user_list_top_begin) . "]";
            update_field('liste_des_top_commences_vkrz', $user_list_top_begin, $id_vainkeur);
        }

    }

    if (is_user_logged_in()) {
        delete_transient('user_' . get_current_user_id() . '_get_user_tops');
    }

    $id_resume          = get_resume_id($id_top);
    $id_ranking_to_supp = (string) $id_ranking;

    // Delete ranking from WP
    wp_delete_post($id_ranking_to_supp, true);

    // Delete ranking from firestore
    apply_filters('firebase_delete_data_from_database', 'firestore', 'wpClassement', $id_ranking_to_supp);
    apply_filters('firebase_delete_data_from_database', 'firestore', 'topLists', $id_ranking_to_supp);
    
    // Save to firebase
    wp_update_post(array('ID' => $id_vainkeur));
    wp_update_post(array('ID' => $id_resume));

    return die(json_encode(array(
        'id_ranking'        => $id_ranking,
        'id_top'            => $id_top,
        'url_top'           => get_permalink($id_top)
    )));

}