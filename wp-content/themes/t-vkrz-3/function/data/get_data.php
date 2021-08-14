<?php
function get_note($id_top, $uuiduser){

    $user_note_of_t = new WP_Query(array(
        'post_type'              => 'note',
        'posts_per_page'         => '1',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'meta_query'             =>
            array(
                'relation' => 'AND',
                array(
                    'key' => 'id_user_n',
                    'value' => $uuiduser,
                    'compare' => '=',
                ),
                array(
                    'key' => 'id_t_n',
                    'value' => $id_top,
                    'compare' => '=',
                )
            )
        )
    );
    while ($user_note_of_t->have_posts()) : $user_note_of_t->the_post();

        $note_id    = get_the_ID();
        $note_value = get_field('id_s_n');

    endwhile;

    wp_reset_postdata();
    wp_reset_query();

    return array(
        "note_value"    => $note_value,
        "note_id"       => $note_id
    );

}