<?php
function save_top_by_creator($post_id){

    global $post;
    $is_new = false;

    if($post->post_date === $post->post_modified){
        $is_new = true;
    }

    if($post->post_type != 'tournoi' || !$is_new){
        return;
    }

    $id_top             = $post_id;
    $top_title          = get_the_title($id_top);
    $top_title          = "Top ".get_field('count_contenders_t', $id_top)." ⚡️ ".$top_title;
    $top_url            = get_the_permalink($id_top);
    $top_question       = get_field('question_t', $id_top);
    $top_visuel         = get_the_post_thumbnail_url($id_top, 'large');
    foreach(get_the_terms($id_top, 'categorie') as $cat ) {
        $cat_id     = $cat->term_id;
        $cat_name   = $cat->name;
    }
    $cat_value          = get_field('icone_cat', 'term_'.$cat_id)." ".$cat_name;

    $creator_id         = get_post_field('post_author', $id_top);
    $creator_data       = get_user_by('ID', $creator_id);
    $creator_name       = $creator_data->nickname;
    $creator_img        = get_avatar_url($creator_id, ['size' => '80']);

    $url    = "https://hook.integromat.com/bo98e5m1k2qsm6sh76nxycshnwwkeghp";
    $args   = array(
        'body' => array(
            'top_title'     => $top_title,
            'top_visuel'    => $top_visuel,
            'top_url'       => $top_url,
            'top_question'  => $top_question,
            'top_autor_img' => $creator_img,
            'top_creator'   => $creator_name,
            'top_cat'       => $cat_value
        )
    );

    wp_remote_post($url, $args);

}
add_action('save_post', 'save_top_by_creator', 10, 2);