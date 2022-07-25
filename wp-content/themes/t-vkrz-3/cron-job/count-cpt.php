<?php
include __DIR__ . '/../../../../wp-load.php';

$list_vainkeur = array();
$i             = 0;

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
    array_push($list_vainkeur, $id_vainkeur);

    echo $i . " : " . $id_vainkeur . "</br>";

    $i++;

endwhile;