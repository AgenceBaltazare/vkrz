<?php

function get_top_infos($id_top, $id_ranking = false){

    global $id_ranking;
    $top_type = false;

    $top_url       = get_the_permalink($id_top);
    $top_title     = get_the_title($id_top);
    $top_question  = get_field('question_t', $id_top);
    $top_img       = get_the_post_thumbnail_url($id_top, 'large');
    $top_cover     = wp_get_attachment_image_src(get_field('cover_t', $id_top), 'large');

    $top_cat_name  = "";
    $top_cat       = get_the_terms($id_top, 'categorie');
    foreach($top_cat as $cat){
        $top_cat_name = $cat->name." ";
    }

    if($id_ranking){
        $top_type       = get_field('type_top_r', $id_ranking);
        if($top_type == "top3"){
            $top_number = 3;
        }
        else{
            $top_number = get_field('count_contenders_t', $id_top);
        }
    }else{
        $top_number = get_field('count_contenders_t', $id_top);
    }

    $display_titre  = get_field('ne_pas_afficher_les_titres_t', $id_top);
    $rounded        = get_field('c_rounded_t', $id_top);
    $c_in_cover     = get_field('visuel_cover_t', $id_top);

    $nb_comments    = get_comments('status=approve&type=comments&hierarchical=true&count=true&post_id='.$id_top);

    $result = array(
        'top_url'       => $top_url,
        'top_cat'       => $top_cat,
        'top_cat_name'  => $top_cat_name,
        'top_title'     => $top_title,
        'top_question'  => $top_question,
        'top_number'    => $top_number,
        'top_type'      => $top_type,
        'top_img'       => $top_img,
        'top_cover'     => $top_cover[0],
        'top_d_titre'   => $display_titre,
        'top_d_rounded' => $rounded,
        'top_d_cover'   => $c_in_cover,
        'top_date'      => get_the_date('d/m/Y', $id_top),
        'nb_comments'   => $nb_comments
    );

    return $result;

}

function get_top_data($id_top){

    $count_votes_of_t       = 0;
    $count_note_of_t        = 0;
    $count_completed_top    = 0;

    $all_ranking_of_t = new WP_Query(array(
        'post_type'                 => 'classement',
        'posts_per_page'            => '-1',
        'ignore_sticky_posts'       => true,
        'update_post_meta_cache'    => false,
        'no_found_rows'             => true,
        'meta_query' => array(
            'relation' => 'AND',
                array(
                    'key'       => 'nb_votes_r',
                    'value'     => 0,
                    'compare'   => '>',
                ),
                array(
                    'key'       => 'id_tournoi_r',
                    'value'     => $id_top,
                    'compare'   => '=',
                )
            )
        )
    );
    while ($all_ranking_of_t->have_posts()) : $all_ranking_of_t->the_post();

        $count_votes_of_t = $count_votes_of_t + get_field('nb_votes_r');
        if (get_field('done_r')) {
            $count_completed_top++;
        }

    endwhile;

    $all_notes_of_t = new WP_Query(array(
        'post_type'                 => 'note',
        'posts_per_page'            => '-1',
        'ignore_sticky_posts'       => true,
        'update_post_meta_cache'    => false,
        'no_found_rows'             => true,
        'meta_query'                => array(
            array(
                'key'       => 'id_t_n',
                'value'     => $id_top,
                'compare'   => '=',
            )
        )
    ));
    while ($all_notes_of_t->have_posts()) : $all_notes_of_t->the_post();

        $top_note        = get_field('id_s_n');
        if($top_note > 3){
            $top_note = 3;
        }
        $count_note_of_t = $count_note_of_t + $top_note;

    endwhile;

    if($all_notes_of_t->post_count > 0){
        $moyenne_note = round($count_note_of_t / $all_notes_of_t->post_count);
    }
    else{
        $moyenne_note = 0;
    }

    $nb_comments    = get_comments('status=approve&type=comments&hierarchical=true&count=true&post_id='.$id_top);

    return array(
        "nb_tops"           => $all_ranking_of_t->post_count,
        "nb_votes"          => $count_votes_of_t,
        "nb_note"           => $all_notes_of_t->post_count,
        "moy_note"          => $moyenne_note,
        "nb_completed_top"  => $count_completed_top,
        'nb_comments'       => $nb_comments
    );
}

function get_exclude_top() {
    $tops = new WP_Query(array(
        'post_type'              => 'tournoi',
        'posts_per_page'         => -1,
        'fields'                 => 'ids',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field'    => 'slug',
                'terms'    => array('onboarding', 'whitelabel')
            ),
        ),
    ));

    return $tops->posts;
}