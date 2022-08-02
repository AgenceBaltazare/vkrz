<?php

include __DIR__ . '/../../../../wp-load.php';

$i = 0;
$list_doublons = array();
$doublon = array();

$vainkeur = new WP_Query(array(
    "post_type"              => "vainkeur",
    "posts_per_page"         => 99999999,
    "fields"                 => "ids",
    "post_status"            => array("publish"),
    "orderby"                => "date",
    "order"                  => "ASC",
    "ignore_sticky_posts"    => true,
    "update_post_meta_cache" => false,
    "no_found_rows"          => false,
    'offset'                 => 17067
));
while ($vainkeur->have_posts()) : $vainkeur->the_post();

    $uuid_user = get_field('uuid_user_vkrz');
    $id_vkrz_1 = get_the_ID();

    $vainkeur_doublon = new WP_Query(array(
        "post_type"              => "vainkeur",
        "posts_per_page"         => -1,
        "fields"                 => "ids",
        "post_status"            => array("publish"),
        "orderby"                => "date",
        "order"                  => "ASC",
        "ignore_sticky_posts"    => true,
        "update_post_meta_cache" => false,
        "no_found_rows"          => false,
        "post__not_in"           => array($id_vkrz_1),
        "meta_query" => array(
            array(
                'key' => 'uuid_user_vkrz',
                'value' => $uuid_user,
                'compare' => '=',
            )
        )
    ));

    echo $i . " : " . $id_vkrz_1;

    if($vainkeur_doublon->have_posts()){

        while ($vainkeur_doublon->have_posts()) : $vainkeur_doublon->the_post();

            $id_vkrz_2 = get_the_ID();

            array_push($list_doublons, array(
                'vkrz1' => $id_vkrz_1,
                'vkrz2' => $id_vkrz_2,
            ));

            echo " <-> " . $id_vkrz_2 . "\n";

        endwhile;

    }
    else{
        echo "\n";
    }

    $i++;

endwhile;