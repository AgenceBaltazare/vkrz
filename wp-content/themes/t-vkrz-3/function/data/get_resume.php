<?php
function get_resume_id($id_top){
    
    $check_resume = new WP_Query(array(
        'ignore_sticky_posts'        => true,
        'update_post_meta_cache'    => false,
        'no_found_rows'                => true,
        'post_type'                    => 'resume',
        'posts_per_page'            => 1,
        'meta_query' => array(
            array(
                'key'       => 'id_top_resume',
                'value'     => $id_top,
                'compare'   => '=',
            )
        )
    ));
    if ($check_resume->have_posts()) {
        $id_resume = wp_list_pluck($check_resume->posts, 'ID');
        $id_resume = $id_resume[0];
    } else {

        $new_resume = array(
            'post_type'   => 'resume',
            'post_title'  => get_the_title($id_top) . " - " . get_field('question_t', $id_top),
            'post_status' => 'publish',
        );
        $id_resume  = wp_insert_post($new_resume);
        update_field('id_top_resume', $id_top, $id_resume);
    }

    return $id_resume;
}