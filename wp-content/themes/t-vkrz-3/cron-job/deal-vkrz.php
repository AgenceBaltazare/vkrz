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
    'meta_query' =>
        array(
            array(
                'key' => 'uuid_user_r',
                'value' => 'fbfd88adb4b09',
                'compare' => '=',
            )
        )
    )
);
while ($classement->have_posts()) : $classement->the_post();

    $id_ranking     = get_the_ID();
    $id_top         = intval(get_field('id_tournoi_r', $id_ranking));
    $id_vainkeur    = intval(get_field('id_tournoi_r', $id_ranking));

    if (get_field('done_r') == "done") {

        if ($id_top) {
            if (!is_null(get_post($id_top))) {

                // Ajout de la TopList dans la liste des TopList du Vainkeur
                $user_list_toplist = array();
                if (get_field('liste_des_toplist_vkrz', $id_vainkeur)) {
                    $user_list_toplist    = json_decode(get_field('liste_des_toplist_vkrz', $id_vainkeur));
                }
                if (!in_array(intval($id_ranking), $user_list_toplist)) {
                    array_push($user_list_toplist, intval($id_ranking));
                    update_field('liste_des_toplist_vkrz', json_encode($user_list_toplist), $id_vainkeur);
                }

                // Mise à jour de la liste des Tops terminés du Vainkeur
                $user_list_top = array();
                if (get_field('liste_des_top_vkrz', $id_vainkeur)) {
                    $user_list_top = json_decode(get_field('liste_des_top_vkrz', $id_vainkeur));
                }
                if (!in_array(intval($id_top), $user_list_top)) {
                    array_push($user_list_top, intval($id_top));
                    update_field('liste_des_top_vkrz', json_encode($user_list_top), $id_vainkeur);
                }

                // Save to firebase
                //wp_update_post(array('ID' => $id_vainkeur));

                echo $i . " : " . $id_ranking . " add \n";

            }
            else{

                wp_delete_post(get_the_ID(), true);
                echo $i . " : " . $id_ranking . " deleted \n";

            }
        }
    }


    $i++;

endwhile;
