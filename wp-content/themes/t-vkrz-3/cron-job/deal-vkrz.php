<?php
include __DIR__ . '/../../../../wp-load.php';

$i = 0;
$classement = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    "fields"                 => "ids",
    'post_type'              => 'classement',
    'post_status'            => array('publish'),
    'posts_per_page'         => -1,
    'order'                  => 'DESC',
    'orderby'                => 'date',
    'meta_query' => array(
        'relation' => 'and',
        array(
            'key' => 'id_vainkeur_r',
            'compare' => 'NOT EXISTS',
        )
    )
));
while ($classement->have_posts()) : $classement->the_post();

    $id_ranking     = get_the_ID();
    $id_top         = intval(get_field('id_tournoi_r', $id_ranking));
    $id_vainkeur    = intval(get_field('id_vainkeur_r', $id_ranking));

    if (get_field('done_r') == "done") {

        if ($id_top) {
            if (!is_null(get_post($id_top))) {

                $id_vainkeur = get_vainkeur_id($uuiduser);
                update_field('id_vainkeur_r', $id_vainkeur, $id_ranking);

                // Save to firebase
                wp_update_post(array('ID' => $id_ranking));

            }
            else{

                wp_delete_post(get_the_ID(), true);

            }
        }
    }


    echo $i . " : " . $id_ranking . "\n";
    $i++;

endwhile;
