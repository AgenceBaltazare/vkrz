<?php
include __DIR__ . '/../../../../wp-load.php';

$nb_votes           = 0;
$nb_tops_complete   = 0;
$nb_tops_notdone    = 0;
$nb_tops_triche     = 0;

$classement = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'classement',
    'posts_per_page'         => 5000,
));
while ($classement->have_posts()) : $classement->the_post();
    
    if(get_field('done_r') == "done"){
        $nb_tops_complete++;
    }
    else{
        $nb_tops_notdone++;
    }

    $nb_votes = $nb_votes + get_field('nb_votes_r');

    if(get_field('suspected_cheating_r')){
        $nb_tops_triche++;
    }

endwhile;

$count_tops     = $classement->post_count;
$pr_triche      = $nb_tops_triche * 100 / $count_tops;
$pr_complete    = $nb_tops_complete * 100 / $count_tops;

echo "Votes : ". $nb_votes."<br>";
echo "Tops : " . $classement->post_count . " (" . round($pr_complete) . "%)<br>";
echo "Triche : " . $nb_tops_triche . " (". round($pr_triche)."%)<br>";
