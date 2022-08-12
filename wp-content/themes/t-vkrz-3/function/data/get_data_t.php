<?php

function get_top_infos($id_top, $id_ranking = false)
{

  global $id_ranking;
  $top_type      = false;
  $top_cover     = "";
  $top_url       = get_the_permalink($id_top);
  $top_title     = get_the_title($id_top);
  $top_question  = get_field('question_t', $id_top);
  $top_img       = get_the_post_thumbnail_url($id_top, 'large');
  $top_cover     = wp_get_attachment_image_src(get_field('cover_t', $id_top), 'large');
  if($top_cover){
    $top_cover = $top_cover[0];
  }
  else{
    $top_cover = "";
  }

  $top_cat_name  = "";
  $top_cat       = get_the_terms($id_top, 'categorie');
  if ($top_cat) {
    foreach ($top_cat as $cat) {
      $top_cat_name = $cat->name . " ";
      $top_cat_icon = get_field('icone_cat', 'term_' . $cat->term_id);
    }
  }


  if ($id_ranking) {
    $top_type       = get_field('type_top_r', $id_ranking);
    if ($top_type == "top3") {
      $top_number = 3;
    } else {
      $top_number = get_field('count_contenders_t', $id_top);
    }
  } else {
    $top_number = get_field('count_contenders_t', $id_top);
  }

  $display_titre  = get_field('ne_pas_afficher_les_titres_t', $id_top);
  $rounded        = get_field('c_rounded_t', $id_top);
  $c_in_cover     = get_field('visuel_cover_t', $id_top);

  $result = array(
    'top_url'       => $top_url,
    'top_cat'       => $top_cat,
    'top_cat_name'  => $top_cat_name,
    'top_cat_icon'  => $top_cat_icon,
    'top_title'     => $top_title,
    'top_question'  => $top_question,
    'top_number'    => $top_number,
    'top_type'      => $top_type,
    'top_img'       => $top_img,
    'top_cover'     => $top_cover,
    'top_d_titre'   => $display_titre,
    'top_d_rounded' => $rounded,
    'top_d_cover'   => $c_in_cover,
    'top_date'      => get_the_date('d/m/Y', $id_top),
  );

  return $result;
}

function get_top_data($id_top)
{

  $id_resume              = get_resume_id($id_top);
  $percent_triche         = 0;
  $percent_finition       = 0;
  $nb_ranks               = get_field('nb_tops_resume', $id_resume);
  $count_votes_of_t       = get_field('nb_votes_resume', $id_resume);
  $count_completed_top    = get_field("nb_done_resume", $id_resume);
  $nb_top_3               = get_field('nb_top_3_resume', $id_resume);;
  $nb_top_complet         = get_field('nb_top_complet_resume', $id_resume);
  $nb_tops_triche         = get_field('nb_triche_resume', $id_resume);
  if ($nb_ranks > 0) {
    $percent_finition   = round($count_completed_top * 100 / $nb_ranks);
  }
  if ($count_completed_top > 0) {
    $percent_triche     = round($nb_tops_triche * 100 / $count_completed_top);
  }
  $nb_comments            = get_comments('status=approve&type=comments&hierarchical=true&count=true&post_id=' . $id_top);

  return array(
    "nb_tops"           => $nb_ranks,
    "nb_votes"          => $count_votes_of_t,
    "nb_completed_top"  => $count_completed_top,
    'nb_comments'       => $nb_comments,
    'nb_top_3'          => $nb_top_3,
    'nb_top_complet'    => $nb_top_complet,
    'percent_finition'  => $percent_finition,
    'percent_triche'    => $percent_triche
  );
}

function get_exclude_top()
{
  $tops = new WP_Query(array(
    'post_type'              => 'tournoi',
    'posts_per_page'         => -1,
    'fields'                 => 'ids',
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'tax_query' => array(
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('onboarding', 'whitelabel', 'private')
      ),
    ),
  ));

  return $tops->posts;
}
