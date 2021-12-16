<?php
include __DIR__ . '/../../../../wp-load.php';

$vainkeur = new WP_Query(array(
    "post_type"              => "vainkeur",
    "posts_per_page"         => 100,
    "fields"                 => "ids",
    "post_status"            => "publish",
    "orderby"                => "date",
    "order"                  => "ASC",
    "ignore_sticky_posts"    => true,
    "update_post_meta_cache" => false,
    "no_found_rows"          => false
));
while ($vainkeur->have_posts()) : $vainkeur->the_post();
    
    $id_vainkeur    = get_the_ID();
    $total_money    = 0;
    $trophy_money   = 0;
    $creator_money  = 0;
    $vainkeur_id    = false;
    $user_pseudo    = "";
    $user_email     = "";
    $user_role      = "";
    $votes_money    = get_field('nb_vote_vkrz');
    $tops_money     = get_field('nb_top_vkrz') * 10;

    $vainkeur_badges = get_the_terms($id_vainkeur, 'badges');
    if($vainkeur_badges){
        foreach ($vainkeur_badges as $badge) {
            $trophy_money = $trophy_money + get_field('recompense_badge', 'badges_' . $badge->term_id);
        }
    }

    $money_vkrz = $trophy_money + $votes_money + $tops_money;

    $user_id = get_the_author_meta('ID');
    if($user_id){
        $user_info   = get_userdata($user_id);
        $user_pseudo = $user_info->nickname;
        $user_email  = $user_info->user_email;
        $user_role   = $user_info->roles[0];

        if ($user_role == "administrator" || $user_role == "author") {
            $data_t_created = get_creator_t($user_id);
        }

        $creator_money = round(($data_t_created['creator_nb_tops'] * 20) + ($data_t_created['creator_all_v'] * 0.01));
    }

    $total_money = $creator_money + $money_vkrz;

    update_field('money_vkrz', $total_money, $id_vainkeur);

endwhile;
