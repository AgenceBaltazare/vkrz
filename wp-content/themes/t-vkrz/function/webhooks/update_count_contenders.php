<?php
add_action('publish_contender', 'update_count_contenders');
add_action('draft_contender', 'update_count_contenders');
add_action('trash_contender', 'update_count_contenders');
add_action('publish_tournoi', 'publish_top_by_creator');

function update_count_contenders($post_id){
    // If create new contender, the query return post without current new contender and get_field doesn't work
    $current_post = 0;
    $top_id       = get_field('id_tournoi_c', $post_id);

    if (!get_field('id_tournoi_c', $post_id)) {
        $current_post = 1;
        $top_id = $_POST["acf"]["field_5eb85c7c80d00"];
    }

    $contenders = new WP_Query(
        array(
            'post_type'              => 'contender',
            'posts_per_page'         => '-1',
            'fields'                 => 'ids',
            'post_status'            => 'publish',
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'no_found_rows'          => false,
            'meta_query'     => array(
                array(
                    'key'     => 'id_tournoi_c',
                    'value'   => $top_id,
                    'compare' => '=',
                )
            )
        )
    );

    update_field('count_contenders_t', $contenders->post_count + $current_post, $top_id);
}
