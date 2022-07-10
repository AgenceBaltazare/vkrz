<?php
include __DIR__ . '/../../../../wp-load.php';

$vainkeur = new WP_Query(array(
    "post_type"              => "vainkeur",
    "posts_per_page"         => -1,
    "fields"                 => "ids",
    "post_status"            => array("publish"),
    "orderby"                => "date",
    "order"                  => "ASC",
    "ignore_sticky_posts"    => true,
    "update_post_meta_cache" => false,
    "no_found_rows"          => false
));
while ($vainkeur->have_posts()) : $vainkeur->the_post();

    $id_vainkeur        = get_the_ID();
    $uuid               = get_field('uuid_user_vkrz', $id_vainkeur);
    $nb_votes           = 0;
    $nb_tops_complete   = 0;
    $money_badges       = 0;
    $money_total        = 0;
    $list_rankings      = array();

    $classement = new WP_Query(array(
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        "fields"                 => "ids",
        'post_type'              => 'classement',
        'post_status'            => array('publish'),
        'posts_per_page'         => 5000,
        'meta_query' => array(
            array(
                'key' => 'uuid_user_r',
                'value' => $uuid,
                'compare' => '=',
            )
        )
    ));
    while ($classement->have_posts()) : $classement->the_post();

        $id_ranking = get_the_ID();

        if (get_field('done_r') == "done") {
            $nb_tops_complete = $nb_tops_complete + 1;
        }

        $nb_votes = $nb_votes + get_field('nb_votes_r');

        array_push($list_rankings, $id_ranking);

    endwhile;

    if($nb_votes <= 0){
        $nb_votes = 0;   
    }
    if ($nb_tops_complete <= 0) {
        $nb_tops_complete = 0;
    }

    update_field('liste_des_toplist_vkrz', $list_rankings, $id_vainkeur);
    update_field('nb_vote_vkrz', $nb_votes, $id_vainkeur);
    update_field('nb_top_vkrz', $nb_tops_complete, $id_vainkeur);

    $vainkeur_badges = get_the_terms($id_vainkeur, 'badges');
    if($vainkeur_badges){
        foreach ($vainkeur_badges as $badge) :
            $badge_money  = get_field('recompense_badge', 'badges_' . $badge->term_id);
            $money_badges = $money_badges + $badge_money;
        endforeach;
    }

    $money_total = $nb_tops_complete * 5 + $nb_votes + $money_badges;
    
    update_field('money_vkrz', $money_total, $id_vainkeur);
    
    check_user_level($id_vainkeur);

    update_field('maj_vkrz', date('Y-m-d H:i:s'), $id_vainkeur);

endwhile;
