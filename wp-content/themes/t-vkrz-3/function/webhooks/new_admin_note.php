<?php
function publish_admin_note($post_id){

    $id_note            = $post_id;

    global $post; 
    if ($post->post_type != 'note'){
        return;
    }

    $noteur_id          = get_post_field('post_author', $id_note);
    $noteur_data        = get_user_by('ID', $noteur_id);
    $noteur_name        = $noteur_data->nickname;
    $noteur_profil      = get_author_posts_url($noteur_id);
    $noteur_uuid        = get_field('id_user_n', $id_note);
    $note_value         = get_field('id_s_n', $id_note);
    $note_comment       = get_field('commentaire_n', $id_note);
    $id_top             = get_field('id_t_n', $id_note);
    $top_infos_to_send  = get_top_infos($id_top);
    $top_title          = "Top ".$top_infos_to_send['top_number']." ⚡️ ".$top_infos_to_send['top_title']." - ".$top_infos_to_send['top_question'];
    $top_url            = get_the_permalink($id_top);

    $url    = "https://hook.integromat.com/joa9qaowupcroxayiq4lvef5k2155n3n";
    $args   = array(
        'body' => array(
            'top_title'     => $top_title,
            'top_url'       => $top_url,
            'id_note'       => $id_note,
            'note_value'    => $note_value,
            'note_comment'  => $note_comment,
            'noteur'        => array(
                'pseudo'    => $noteur_name,
                'profil'    => $noteur_profil,
                'uuid'      => $noteur_uuid,
            )
        )
    );

    wp_remote_post($url, $args);

}
add_action('publish_note', 'publish_admin_note');
add_action('save_note', 'publish_admin_note');
