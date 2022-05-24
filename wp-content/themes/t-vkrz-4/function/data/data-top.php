<?php
function get_top_infos($data){

    $id_top        = $data['id_top'];

    $top_url       = get_the_permalink($id_top);
    $top_title     = get_the_title($id_top);
    $top_question  = get_field('question_t', $id_top);
    $top_img       = get_the_post_thumbnail_url($id_top, 'large');
    $top_cover     = wp_get_attachment_image_src(get_field('cover_t', $id_top), 'large');
    $top_cat_name  = "";
    $top_cat       = get_the_terms($id_top, 'categorie');
    if ($top_cat) {
        foreach ($top_cat as $cat) {
            $top_cat_name = $cat->name . " ";
        }
    }
    $display_titre  = get_field('ne_pas_afficher_les_titres_t', $id_top);
    $rounded        = get_field('c_rounded_t', $id_top);
    $c_in_cover     = get_field('visuel_cover_t', $id_top);
    $nb_comments    = get_comments('status=approve&type=comments&hierarchical=true&count=true&post_id=' . $id_top);
    $result = array(
        'top_url'       => $top_url,
        'top_cat'       => $top_cat,
        'top_cat_name'  => $top_cat_name,
        'top_title'     => $top_title,
        'top_question'  => $top_question,
        'top_img'       => $top_img,
        'top_cover'     => $top_cover[0],
        'top_d_titre'   => $display_titre,
        'top_d_rounded' => $rounded,
        'top_d_cover'   => $c_in_cover,
        'top_date'      => get_the_date('d/m/Y', $id_top),
        'nb_comments'   => $nb_comments
    );

    return $result;
}