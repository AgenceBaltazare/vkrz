<?php
function do_commentaire_note($id_tournament, $uuiduser, $commentaire_note){

    $commentaire_note   = Strip_tags($commentaire_note);
    $note               = get_note($id_tournament, $uuiduser);
    $id_note            = $note[0]['id_note'];

    if($id_note){

        update_field('commentaire_n', $commentaire_note, $id_note);

    }
    else{

        $new_note = array(
            'post_type'   => 'note',
            'post_title'  => 'U:' . $uuiduser . ' T:' . $id_tournament,
            'post_status' => 'publish',
        );
        $id_new_note  = wp_insert_post($new_note);

        update_field('id_user_n', $uuiduser, $id_new_note);
        update_field('id_t_n', $id_tournament, $id_new_note);
        update_field('commentaire_n', $commentaire_note, $id_new_note);

    }
}