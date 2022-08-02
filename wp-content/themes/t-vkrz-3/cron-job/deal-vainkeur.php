<?php

include __DIR__ . '/../../../../wp-load.php';

$i = 0;
$vainkeur = new WP_Query(array(
    "post_type"              => "vainkeur",
    "posts_per_page"         => -1,
    "fields"                 => "ids",
    "orderby"                => "date",
    "order"                  => "ASC",
    "ignore_sticky_posts"    => true,
    "update_post_meta_cache" => false,
    "no_found_rows"          => false,
    "meta_query" => array(
        "relation" => "OR",
        array(
            'key'     => 'maj_vkrz',
            'compare' => 'NOT EXISTS',
        ),
        array(
            'key'     => 'maj_vkrz',
            'value'   => '',
            'compare' => '=',
        )
    )
));
while ($vainkeur->have_posts()) : $vainkeur->the_post();

    $id_vainkeur        = get_the_ID();
    $uuid               = get_field('uuid_user_vkrz', $id_vainkeur);
    $vainkeur_toplist   = json_decode(get_field('liste_des_toplist_vkrz', $id_vainkeur));
    $nb_votes           = 0;
    $nb_tops_complete   = 0;
    $money_creator      = 0;
    $money_badges       = 0;
    $money_recompense   = 0;
    $money_depense      = 0;
    $money_dispo        = 0;
    $money_total        = 0;
    $list_toplist       = array();
    $list_tops          = array();
    $list_tops_begin    = array();

    foreach ($vainkeur_toplist as $id_ranking) {

        $id_top = intval(get_field('id_tournoi_r', $id_ranking));

        if ($id_top) {
            $nb_tops_complete = $nb_tops_complete + 1;
            $nb_votes         = $nb_votes + get_field('nb_votes_r', $id_ranking);
        }

        if (is_null(get_post($id_top))) {

            wp_delete_post($id_ranking, true);

            // Mise à jour de la liste des TopList du Vainkeur
            if (get_field('liste_des_toplist_vkrz', $id_vainkeur)) {
                $user_list_toplist = json_decode(get_field('liste_des_toplist_vkrz', $id_vainkeur));
                $user_list_toplist = array_diff($user_list_toplist, array($id_ranking));
                update_field('liste_des_toplist_vkrz', json_encode($user_list_toplist), $id_vainkeur);
            }

            // Mise à jour de la liste des Tops terminés du Vainkeur
            if (get_field('liste_des_top_vkrz', $id_vainkeur)) {
                $user_list_top = json_decode(get_field('liste_des_top_vkrz', $id_vainkeur));
                $user_list_top = array_diff($user_list_top, array($id_top));
                update_field('liste_des_top_vkrz', json_encode($user_list_top), $id_vainkeur);
            }
        }
    }

    if ($nb_votes <= 0) {
        $nb_votes = 0;
    }
    if ($nb_tops_complete <= 0) {
        $nb_tops_complete = 0;
    }

    update_field('nb_vote_vkrz', $nb_votes, $id_vainkeur);
    update_field('nb_top_vkrz', $nb_tops_complete, $id_vainkeur);

    $vainkeur_badges = get_the_terms($id_vainkeur, 'badges');
    if ($vainkeur_badges) {
        foreach ($vainkeur_badges as $badge) :
            $badge_money  = get_field('recompense_badge', 'badges_' . $badge->term_id);
            $money_badges = $money_badges + $badge_money;
        endforeach;
    }

    if (have_rows('liste_des_recompenses_vkrz', $id_vainkeur)) {
        while (have_rows('liste_des_recompenses_vkrz', $id_vainkeur)) : the_row();
            $recompense_money  = get_sub_field('prix_recompense_vkrz');
            $money_recompense  = $money_recompense + $recompense_money;
        endwhile;
    }

    $money_creator  = get_field('money_creator_vkrz', $id_vainkeur);
    $money_total    = $nb_tops_complete * 5 + $nb_votes + $money_badges + $money_recompense;
    update_field('money_vkrz', $money_total, $id_vainkeur);

    $transaction = new WP_Query(array(
        'ignore_sticky_posts'       => true,
        'update_post_meta_cache'    => false,
        'no_found_rows'             => true,
        'post_type'                 => 'transaction',
        'orderby'                   => 'date',
        'order'                     => 'DESC',
        'posts_per_page'            => -1,
        'meta_query'                => array(
            array(
                'key'     => 'id_vainkeur_transaction',
                'value'   => $id_vainkeur,
                'compare' => '=',
            )
        )
    ));
    while ($transaction->have_posts()) : $transaction->the_post();

        $money_depense = $money_depense + get_field('montant_transaction');

    endwhile;
    wp_reset_query();

    $money_dispo = $money_total - $money_depense + $money_creator;
    update_field('money_disponible_vkrz', $money_dispo, $id_vainkeur);

    check_user_level($id_vainkeur);

    update_field('maj_vkrz', date('Y-m-d H:i:s'), $id_vainkeur);

    // Save to firebase
    wp_update_post(array('ID' => $id_vainkeur));

    echo $i . " : " . $id_vainkeur . " - Money dispo : " . $money_dispo . "\n";

    $i++;

endwhile;
