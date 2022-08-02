<?php
include __DIR__ . '/../../../../wp-load.php';

$nb_votes           = 0;
$nb_tops_complete   = 0;
$nb_tops_again      = 0;
$nb_tops_notdone    = 0;
$nb_tops_triche     = 0;
$type_top_3         = 0;
$type_top_complet   = 0;

$resume = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'resume',
    'posts_per_page'         => -1,
));
while ($resume->have_posts()) : $resume->the_post();
    
    $nb_tops_complete = $nb_tops_complete + intval(get_field('nb_done_resume'));

    $nb_votes = $nb_votes + get_field('nb_votes_resume');

    if(get_field('nb_triche_resume')){
        $nb_tops_triche++;
    }

    if (get_field('nb_top_3_resume')) {
        $type_top_3++;
    }
    if (get_field('nb_top_complet_resume')) {
        $type_top_complet++;
    }

endwhile;

$total_money = 0;
$total_disponible = 0;
$total_money_creator = 0;


$pr_triche      = $nb_tops_triche * 100 / $count_tops;
$pr_complete    = $nb_tops_complete * 100 / $count_tops;
$pr_top3        = $type_top_3 * 100 / $count_tops;
$pr_complet     = $type_top_complet * 100 / $count_tops;

echo "Votes : ". $nb_votes."\n";
echo "Tops : " . $nb_tops_complete."\n";
echo "Tops recommencés : " . $nb_tops_again . "\n";
echo "Triche : " . $nb_tops_triche . " (" . round($pr_triche) . "%)\n";
echo "Top 3 : " . $type_top_3 . " (" . round($pr_top3) . "%)\n";
echo "Complet : " . $type_top_complet . " (". round($pr_complet)."%)\n";


