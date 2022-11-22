<?php
include __DIR__ . '/../../../../wp-load.php';
/**
 * CRON JOB : Update global money
 *
 * When : Everyday @ 02:45
 */

$list_vainkeur_to_update = array();
$vainkeurs_with_child = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'vainkeur',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => -1,
    'meta_query' => array(
        array(
            'key'     => 'referral_from_me',
            'compare' => 'EXISTS',
        ),
    ),
));
while ($vainkeurs_with_child->have_posts()) : $vainkeurs_with_child->the_post();

    array_push($list_vainkeur_to_update, get_the_ID());

endwhile;

$user_query = new WP_User_Query(
    array(
        'number' => -1,
        'role__in' => array('administrator', 'author')
    )
);
$users = $user_query->get_results();
foreach ($users as $user) {
    $vainkeur_entry = new WP_Query(array(
        'post_type'              => 'vainkeur',
        'posts_per_page'         => '1',
        'fields'                 => 'ids',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'author'                 => $user_id
    ));

    if ($vainkeur_entry->have_posts()) {

        $id_vainkeur = $vainkeur_entry->posts[0];
        array_push($list_vainkeur_to_update, $id_vainkeur);

    }
}
wp_reset_query();

$list_vainkeur_to_update_unique = array_unique($list_vainkeur_to_update);

$vainkeurs_to_update = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'vainkeur',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => -1,
    'post__in'               => $list_vainkeur_to_update_unique
));
while ($vainkeurs_to_update->have_posts()) : $vainkeurs_to_update->the_post();

    $id_vainkeur        = get_the_ID();
    
    // delete Transaction
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

    // add récompenses
    if (have_rows('liste_des_recompenses_vkrz', $id_vainkeur)) {
        while (have_rows('liste_des_recompenses_vkrz', $id_vainkeur)) : the_row();
            $recompense_money  = get_sub_field('prix_recompense_vkrz');
            $money_recompense  = $money_recompense + $recompense_money;
        endwhile;
    }

    $money_xp           = get_field('money_vkrz', $id_vainkeur);
    $money_creator      = get_field('money_creator_vkrz', $id_vainkeur);
    $money_parrain      = get_field('money_parrainage_vkrz', $id_vainkeur);
    $money_duplicated   = get_field('money_duplication_vkrz', $id_vainkeur);
    $money_dispo        = get_field('money_disponible_vkrz', $id_vainkeur);

    $new_money_dispo    = round($money_xp + $money_creator + $money_duplicated + $money_parrain + $money_recompense - $money_depense);

    update_field('money_disponible_vkrz', $new_money_dispo, $id_vainkeur);

endwhile;
