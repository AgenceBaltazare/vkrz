<?php
include __DIR__ . '/../../../../wp-load.php';

$classement = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'classement',
    'post_status'            => array('publish', 'draft', 'trash'),
    'posts_per_page'         => -1
));
while ($classement->have_posts()) : $classement->the_post();

    $id_top     = get_field('id_tournoi_r');
    $id_ranking = get_the_ID();

    $check_resume = new WP_Query(array(
        'ignore_sticky_posts'	    => true,
        'update_post_meta_cache'    => false,
        'no_found_rows'		        => true,
        'post_type'			        => 'resume',
        'posts_per_page'		    => 1,
        'meta_query' => array(
            array(
                'key'       => 'id_top_resume',
                'value'     => $id_top,
                'compare'   => '=',
            )
        )
    ));
    if($check_resume->have_posts()){
        $id_resume = wp_list_pluck($check_resume->posts, 'ID');
        $id_resume = $id_resume[0];
    }
    else{

        $new_resume = array(
            'post_type'   => 'resume',
            'post_title'  => get_the_title($id_top)." - ".get_field('question_t', $id_top),
            'post_status' => 'publish',
        );
        $id_resume  = wp_insert_post($new_resume);
        update_field('id_top_resume', $id_top, $id_resume);

    }

    $nb_votes           = get_field('nb_votes_resume', $id_resume);
    $nb_tops            = get_field('nb_tops_resume', $id_resume);
    $nb_tops_complete   = get_field("nb_done_resume", $id_resume);
    $nb_tops_again      = get_field('nb_again_resume', $id_resume);
    $nb_tops_triche     = get_field('nb_triche_resume', $id_resume);
    $type_top_3         = get_field('nb_top_3_resume', $id_resume);
    $type_top_complet   = get_field('nb_top_complet_resume', $id_resume);

    if (get_field('done_r', $id_ranking) == "done") {
        $nb_tops_complete++;
    }

    $nb_votes = $nb_votes + get_field('nb_votes_r', $id_ranking);
    $nb_tops++;

    if (get_field('suspected_cheating_r', $id_ranking)) {
        $nb_tops_triche++;
    }

    if (get_field('type_top_r', $id_ranking) == "top3") {
        $type_top_3++;
    } 
    elseif (get_field('type_top_r', $id_ranking) == "complet") {
        $type_top_complet++;
    }

    if (get_post_status($id_ranking) == 'draft') {
        $nb_tops_again++;
    }

    update_field('nb_votes_resume', $nb_votes, $id_resume);
    update_field('nb_tops_resume', $nb_tops, $id_resume);
    update_field('nb_done_resume', $nb_tops_complete, $id_resume);
    update_field('nb_top_3_resume', $type_top_3, $id_resume);
    update_field('nb_top_complet_resume', $type_top_complet, $id_resume);
    update_field('nb_triche_resume', $nb_tops_triche, $id_resume);
    update_field('nb_again_resume', $nb_tops_again, $id_resume);

endwhile;
