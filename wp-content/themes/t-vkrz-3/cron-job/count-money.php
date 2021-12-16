<?php
include __DIR__ . '/../../../../wp-load.php';

$total_money = 0;

$vainkeur = new WP_Query(array(
    "post_type"              => "vainkeur",
    "posts_per_page"         => -1,
    "fields"                 => "ids",
    "post_status"            => "publish",
    "orderby"                => "date",
    "order"                  => "ASC",
    "ignore_sticky_posts"    => true,
    "update_post_meta_cache" => false,
    "no_found_rows"          => false
));
while ($vainkeur->have_posts()) : $vainkeur->the_post();

    $total_money = $total_money + get_field('money_vkrz');

endwhile;

echo $total_money;
