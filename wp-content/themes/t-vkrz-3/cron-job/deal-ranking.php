<?php
include __DIR__ . '/../../../../wp-load.php';

$i = 0;
$classement = new WP_Query(
    array(
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        "fields"                 => "ids",
        'post_type'              => 'classement',
        'post_status'            => array('publish'),
        'posts_per_page'         => 10000,
        'order'                  => 'DESC',
        'orderby'                => 'date'
    )
);
while ($classement->have_posts()) : $classement->the_post();

    echo $i . " : " . $id_ranking;

    if (get_field('done_r') != "done") {

        $id_ranking     = get_the_ID();
        wp_delete_post(get_the_ID(), true);
        echo " deleted \n";
        
    }

    $i++;

endwhile;
