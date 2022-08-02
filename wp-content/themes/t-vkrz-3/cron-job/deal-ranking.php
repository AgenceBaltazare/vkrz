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
        'posts_per_page'         => -1,
        'order'                  => 'DESC',
        'orderby'                => 'date'
    )
);
while ($classement->have_posts()) : $classement->the_post();

    if (get_field('done_r') != "done") {

        //wp_delete_post(get_the_ID(), true);
        echo $i . " : " . $id_ranking . " deleted \n";
        $i++;
    }

endwhile;
