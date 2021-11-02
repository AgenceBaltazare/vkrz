<?php
function get_contenders_ranking($top_id){
    $contenders_ranking = array();
    $contenders = new WP_Query(array(
        'post_type'         => 'contender',
        'meta_key'          => 'ELO_c',
        'orderby'           => 'meta_value_num',
        'posts_per_page'    => '-1',
        'meta_query'        => array(
            array(
                'key'     => 'id_tournoi_c',
                'value'   => $top_id,
                'compare' => '=',
            )
        )
    ));

    if ($contenders->have_posts()) {
        foreach ($contenders->posts as $contender) {
            $contender_id = $contender->ID;

            $contenders_ranking[] = array(
                "id" => $contender_id,
                "illustration" => get_the_post_thumbnail_url($contender_id, 'full'),
                "title" => get_the_title($contender_id),
                "points" => get_field("ELO_c", $contender_id)
            );
        }
    }
    
    return $contenders_ranking;
}

function get_contenders_ranking_json($top_id) {
    return die(json_encode(get_contenders_ranking($top_id)));
}