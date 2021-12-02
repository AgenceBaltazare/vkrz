<?php
include __DIR__ . '/../../../../wp-load.php';

$user_query = new WP_User_Query(array(
    "number" => 100,
    'orderby' => 'registered', 'order' => 'ASC'
));
foreach ($user_query->get_results() as $user) {
    $vainkeur = new WP_Query(array(
        "post_type"              => "vainkeur",
        "posts_per_page"         => "1",
        "fields"                 => "ids",
        "post_status"            => "publish",
        "ignore_sticky_posts"    => true,
        "update_post_meta_cache" => false,
        "no_found_rows"          => false,
        "author__in"             => $user->ID,
    ));

    if ($vainkeur->have_posts()) {
        $vainkeur_id = $vainkeur->posts[0];
        $total_vote = get_field("nb_vote_vkrz", $vainkeur_id);
        $total_top = get_field("nb_top_vkrz", $vainkeur_id);
    }

    $users[] = array(
        "id" => $user->ID,
        "registered" => $user->user_registered,
        "pseudo" => $user->user_nicename,
        "total_vote" => $total_vote,
        "total_top" => $total_top,
    );

    echo $user->ID . " " . $user->user_registered . " " . $user->user_nicename . " " . $total_vote . " votes - " . $total_top . " tops <br>";

    update_vainkeur_badge($vainkeur_id, "Visionnaire");

}

