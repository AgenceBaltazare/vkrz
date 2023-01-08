<?php
function get_resume_id($id_top)
{

    if (get_field('id_du_resume_t', $id_top)) {
        $id_resume = get_field('id_du_resume_t', $id_top);
    } else {

        if (get_post_type($id_top) == "tournoi") {
            $new_resume = array(
                'post_type'   => 'resume',
                'post_title'  => get_the_title($id_top) . " - " . get_field('question_t', $id_top),
                'post_status' => 'publish',
            );
            $id_resume  = wp_insert_post($new_resume);
            update_field('id_top_resume', $id_top, $id_resume);

            update_field('id_du_resume_t', $id_resume, $id_top);
        }
    }

    if ($id_resume) {
        return $id_resume;
    } else {
        return false;
    }
}
