<?php
function publish_top_by_creator($post_id){

    global $post;

    if($post->post_type != 'tournoi'){
        return;
    }

    $id_top             = $post_id;

    // Générer la TopList Mondiale et le listing
    generate_toplist_mondiale($id_top);

    $top_infos_to_send  = get_top_infos($id_top);
    $top_title          = $top_infos_to_send['top_title'];
    $top_title          = "Top ".$top_infos_to_send['top_number']." ⚡️ ".$top_title;
    $top_url            = get_the_permalink($id_top);
    $top_question       = $top_infos_to_send['top_question'];
    $top_visuel         = $top_infos_to_send['top_img'];
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
add_action('publish_tournoi', 'publish_top_by_creator');