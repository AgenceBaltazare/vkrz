<?php
function do_note($id_top, $uuiduser, $star){

    $note               = get_note($id_top, $uuiduser);
    $note_id            = $note['note_id'];

    if($note_id){

        update_field('id_s_n', $star, $note_id);

    }
    else{

        $new_note = array(
            'post_type'   => 'note',
            'post_title'  => 'U:' . $uuiduser . ' T:' . $id_top,
            'post_status' => 'publish',
        );
        $id_new_note  = wp_insert_post($new_note);

        update_field('id_user_n', $uuiduser, $id_new_note);
        update_field('id_t_n', $id_top, $id_new_note);
        update_field('id_s_n', $star, $id_new_note);

    }

}