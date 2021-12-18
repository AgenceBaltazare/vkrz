<?php
include __DIR__ . '/../../../../wp-load.php';

$total_money = 0;
$total_money_creator = 0;

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

    $user_id = get_the_author_meta('ID');
    if ($user_id) {

        $total_money_creator = $total_money_creator + get_field('money_creator_vkrz');

    }


endwhile;

echo "Money vainkeur : " . $total_money. "\n";
echo "Money creator : " . $total_money_creator . "\n";
