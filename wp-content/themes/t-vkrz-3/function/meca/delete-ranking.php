<?php
function delete_real_ranking($id_ranking, $id_vainkeur){

    if(isset($id_ranking) && $id_ranking != ""){

        $nb_to_decrease     = get_field('nb_votes_r', $id_ranking);
        $id_top             = get_field('id_tournoi_r', $id_ranking);
        
        decrease_user_counter($id_vainkeur, $id_ranking);
        increase_top_resume($id_ranking, 'again');

        wp_delete_post($id_ranking, true);

        // Mise à jour de la liste des TopList du Vainkeur
        $user_list_toplist = array();
        if(get_field('liste_des_toplist_vkrz', $id_vainkeur)){
            $user_list_toplist = json_decode(get_field('liste_des_toplist_vkrz', $id_vainkeur));
        }
        $user_list_toplist = array_diff($user_list_toplist, array($id_ranking));
        update_field('liste_des_toplist_vkrz', json_encode($user_list_toplist), $id_vainkeur);

        // Mise à jour de la liste des Tops terminés du Vainkeur
        $user_list_top = array();
        if (get_field('liste_des_top_vkrz', $id_vainkeur)) {
            $user_list_top = json_decode(get_field('liste_des_top_vkrz', $id_vainkeur));
        }
        $user_list_top = array_diff($user_list_top, array($id_top));
        update_field('liste_des_top_vkrz', json_encode($user_list_top), $id_vainkeur);

        // Suppression du Top dans la liste des Tops commencé du Vainkeur
        $user_list_top_begin = array();
        if (get_field('liste_des_top_commences_vkrz', $id_vainkeur)) {
            $user_list_top_begin = json_decode(get_field('liste_des_top_commences_vkrz', $id_vainkeur));
        }
        $user_list_top_begin = array_diff($user_list_top_begin, array($id_top));
        update_field('liste_des_top_commences_vkrz', json_encode($user_list_top_begin), $id_vainkeur);

    }

    if (is_user_logged_in()) {
        delete_transient('user_' . get_current_user_id() . '_get_user_tops');
    }

    return die(json_encode(array(
        'id_ranking'        => $id_ranking,
        'id_top'            => $id_top,
        'url_top'           => get_permalink($id_top)
    )));

}