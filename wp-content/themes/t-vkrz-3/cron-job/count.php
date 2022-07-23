<?php
include __DIR__ . '/../../../../wp-load.php';

$nb_votes           = 0;
$nb_tops_complete   = 0;
$nb_tops_again      = 0;
$nb_tops_notdone    = 0;
$nb_tops_triche     = 0;
$type_top_3         = 0;
$type_top_complet   = 0;

$classement = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'classement',
    'post_status'            => array('publish', 'draft', 'trash'),
    'posts_per_page'         => -1,
));
while ($classement->have_posts()) : $classement->the_post();
    
    if(get_field('done_r') == "done"){
        $nb_tops_complete = $nb_tops_complete + 1;
    }
    else{
        $nb_tops_notdone = $nb_tops_notdone + 1;
    }

    $nb_votes = $nb_votes + get_field('nb_votes_r');

    if(get_field('suspected_cheating_r')){
        $nb_tops_triche++;
    }

    if (get_field('type_top_r') == "top3") {
        $type_top_3++;
    } elseif (get_field('type_top_r') == "complet") {
        $type_top_complet++;
    }

    if(get_post_status() == 'draft'){
        $nb_tops_again++;
    }

endwhile;

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

$count_tops     = $classement->post_count;
$pr_triche      = $nb_tops_triche * 100 / $count_tops;
$pr_complete    = $nb_tops_complete * 100 / $count_tops;
$pr_top3        = $type_top_3 * 100 / $count_tops;
$pr_complet     = $type_top_complet * 100 / $count_tops;

echo "Votes : ". $nb_votes."\n";
echo "Tops : " . $classement->post_count . " (" . round($pr_complete) . "%)\n";
echo "Tops finis: " . $nb_tops_complete."\n";
echo "Tops non fini: " . $nb_tops_notdone . "\n";
echo "Tops recommencés: " . $nb_tops_again . "\n";
echo "Triche : " . $nb_tops_triche . " (" . round($pr_triche) . "%)\n";
echo "Top 3 : " . $type_top_3 . " (" . round($pr_top3) . "%)\n";
echo "Complet : " . $type_top_complet . " (". round($pr_complet)."%)\n";
echo "Money vainkeur : " . $total_money . "\n";
echo "Money creator : " . $total_money_creator . "\n";

