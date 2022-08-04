<?php
function begin_t($id_top, $uuiduser, $typetop, $id_vainkeur)
{

    $utm = "";
    
    global $utm;

    if (!$utm && isset($_COOKIE['vainkeurz_user_utm']) && $_COOKIE['vainkeurz_user_utm'] != "") {
        $utm = $_COOKIE['vainkeurz_user_utm'];
    }

    // set cookies to create vainkeur CPT
    setcookie("vainkeur_ready_to_be_create", $uuiduser, time() + 31556926, "/");

    if ($typetop == "top3") {
        $title_rank = 'Podium ' . get_the_title($id_top);
    } else {
        $title_rank = 'Top ' . get_field('count_contenders_t', $id_top) . ' - ' . get_the_title($id_top);
    }

    $get_top_type = get_the_terms($id_top, 'type');
    foreach ($get_top_type as $type_top) {
        $type_top = $type_top->slug;
    }

    // Ajout du Top dans la liste des Tops commencé du Vainkeur
    $user_list_top_begin    = array();
    if (get_field('liste_des_top_commences_vkrz', $id_vainkeur)) {
        $user_list_top_begin    = json_decode(get_field('liste_des_top_commences_vkrz', $id_vainkeur));
    }
    if (!in_array(intval($id_top), $user_list_top_begin)) {
        array_push($user_list_top_begin, intval($id_top));
        update_field('liste_des_top_commences_vkrz', json_encode($user_list_top_begin), $id_vainkeur);
    }

    // Création d'un CPT classement
    $new_ranking = array(
        'post_type'   => 'classement',
        'post_title'  => $title_rank,
        'post_status' => 'publish',
    );
    $id_ranking  = wp_insert_post($new_ranking);

    $list_contenders = array();

    $contenders = new WP_Query(
        array(
            'post_type'      => 'contender',
            'posts_per_page' => -1,
            'meta_key'       => 'ELO_c',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'no_found_rows'          => true,
            'meta_query'     => array(
                array(
                    'key'     => 'id_tournoi_c',
                    'value'   => $id_top,
                    'compare' => '=',
                )
            )
        )
    );
    $i = 0;
    while ($contenders->have_posts()) : $contenders->the_post();

        array_push($list_contenders, array(
            "id"                => $i,
            "id_wp"             => get_the_ID(),
            "elo"               => get_field('ELO_c'),
            "c_name"            => get_the_title(),
            "more_to"           => array(),
            "less_to"           => array(),
            "place"             => 0,
            "ratio"             => 0,
        ));

        $i++;
    endwhile;

    wp_set_post_terms($id_ranking, $type_top, 'type');
    update_field('type_top_r', $typetop, $id_ranking);
    update_field('uuid_user_r', $uuiduser, $id_ranking);
    update_field('id_tournoi_r', $id_top, $id_ranking);
    update_field('id_vainkeur_r', $id_vainkeur, $id_ranking);
    update_field('ranking_r', $list_contenders, $id_ranking);
    update_field('nb_votes_r', 0, $id_ranking);
    update_field('timeline_main', 1, $id_ranking);
    update_field('timeline_2', 0, $id_ranking);
    update_field('timeline_4', 0, $id_ranking);
    update_field('timeline_5', 0, $id_ranking);
    update_field('utm_campaign_r', $utm, $id_ranking);

    if (is_user_logged_in()) {
        global $user_id;
        if ($user_id && !get_field('uuiduser_user', 'user_' . $user_id) && $uuiduser) {
            update_field('uuiduser_user', $uuiduser, 'user_' . $user_id);
        }
    }

    increase_top_resume($id_ranking, 'new');

    return $id_ranking;
}
