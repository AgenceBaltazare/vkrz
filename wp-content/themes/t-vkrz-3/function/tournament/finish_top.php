<?php
function finish_the_top($id_ranking, $current_id_vainkeur, $id_top, $nb_contenders){

    $user_list_toplist      = array();
    $user_list_top          = array();
    $user_list_top_begin    = array();

    date_default_timezone_set('Europe/Paris');
    $is_suspected_cheating = suspected_cheating(get_the_date('Y-m-d H:i:s', $id_ranking), date('Y-m-d H:i:s'), get_field('nb_votes_r', $id_ranking));

    update_field('done_r', 'done', $id_ranking);
    update_field('done_date_r', date('Y-m-d H:i:s'), $id_ranking);
    update_field('suspected_cheating_r', $is_suspected_cheating, $id_ranking);

    if (!in_array($id_top, get_exclude_top())) {
        increase_top_counter($current_id_vainkeur, $id_top);
    }

    increase_top_resume($id_ranking, 'finish');

    // Badge : Top with at least 50 contenders
    if (!get_vainkeur_badge($current_id_vainkeur, "BIG TOP")) {
        if ($nb_contenders >= 50) {
            $badge_data = update_vainkeur_badge($current_id_vainkeur, "BIG TOP");
        }
    }

    // Badge : Top with at least 100 contenders
    if (!get_vainkeur_badge($current_id_vainkeur, "BIG BIG TOP")) {
        if ($nb_contenders >= 100) {
            $badge_data = update_vainkeur_badge($current_id_vainkeur, "BIG BIG TOP");
        }
    }

    // Ajout de la TopList dans la liste des TopList du Vainkeur
    $user_list_toplist = array();
    if (get_field('liste_des_toplist_vkrz', $current_id_vainkeur)) {
        $user_list_toplist    = json_decode(get_field('liste_des_toplist_vkrz', $current_id_vainkeur));
    }
    if (!in_array(intval($id_ranking), $user_list_toplist)) {
        array_push($user_list_toplist, intval($id_ranking));
        update_field('liste_des_toplist_vkrz', json_encode($user_list_toplist), $current_id_vainkeur);
    }
    // Suppression de la TopList dans la liste des TopList commencées du Vainkeur
    $user_list_toplist_begin = array();
    if (get_field('liste_des_toplist_commence_vkrz', $current_id_vainkeur)) {
        $user_list_toplist_begin = json_decode(get_field('liste_des_toplist_commence_vkrz', $current_id_vainkeur));
    }
    $user_list_toplist_begin = array_diff($user_list_toplist_begin, array($id_top));
    update_field('liste_des_toplist_commence_vkrz', json_encode($user_list_toplist_begin), $current_id_vainkeur);

    // Mise à jour de la liste des Tops terminés du Vainkeur
    $user_list_top = array();
    if(get_field('liste_des_top_vkrz', $current_id_vainkeur)){
        $user_list_top = json_decode(get_field('liste_des_top_vkrz', $current_id_vainkeur));
    }
    if(!in_array(intval($id_top), $user_list_top)){
        array_push($user_list_top, intval($id_top));
        update_field('liste_des_top_vkrz', json_encode($user_list_top), $current_id_vainkeur);
    }
    // Suppression du Top dans la liste des Tops commencé du Vainkeur
    $user_list_top_begin = array();
    if (get_field('liste_des_top_commences_vkrz', $current_id_vainkeur)) {
        $user_list_top_begin = json_decode(get_field('liste_des_top_commences_vkrz', $current_id_vainkeur));
    }
    $user_list_top_begin = array_diff($user_list_top_begin, array($id_top));
    update_field('liste_des_top_commences_vkrz', json_encode($user_list_top_begin), $current_id_vainkeur);

    if (is_user_logged_in()) {
        delete_transient('user_' . get_current_user_id() . '_get_user_tops');
    }
}