<?php

// Get numbers of contenders in a tournament
function get_numbers_of_contenders($id_top) {

    $contenders_top = new WP_Query(
        array(
            'post_type'              => 'contender',
            'posts_per_page'         => '300',
            'fields'                 => 'ids',
            'post_status'            => 'publish',
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'no_found_rows'          => false,
            'meta_query'     => array(
                array(
                    'key'     => 'id_tournoi_c',
                    'value'   => $id_top,
                    'compare' => '=',
                )
            )
        )
    );

    $nb_contenders = $contenders_top->post_count;

    return $nb_contenders;
}

function get_top_infos($id_top, $id_ranking = false){

    global $id_ranking;

    $top_url       = get_the_permalink($id_top);
    $top_title     = get_the_title($id_top);
    $top_question  = get_field('question_t', $id_top);
    $top_img       = get_the_post_thumbnail_url($id_top, 'large');
    $top_cover     = wp_get_attachment_image_src(get_field('cover_t', $id_top), 'large');

    if($id_ranking){
        $typetop       = get_field('type_top_r', $id_ranking);
        if($typetop == "top3"){
            $top_number = 3;
        }
        else{
            $top_number = get_numbers_of_contenders($id_top);
        }
    }else{
        $top_number = get_numbers_of_contenders($id_top);
    }

    $result = array(
        'top_url'       => $top_url,
        'top_title'     => $top_title,
        'top_question'  => $top_question,
        'top_number'    => $top_number,
        'top_img'       => $top_img,
        'top_cover'     => $top_cover
    );

    return $result;

}