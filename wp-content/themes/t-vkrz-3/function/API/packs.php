<?php
require_once('fct.php');

function get_user_infos_from_api($data)
{

  $uuiduser        = $data['uuiduser'];

  $id_vainkeur        = false;
  $user_id            = false;
  $user_pseudo        = "";
  $avatar_url         = "";
  $user_role          = "";
  $user_email         = "";
  $nb_top_vkrz        = 0;
  $nb_vote_vkrz       = 0;
  $info_user_level    = array(
    "level_ico"     => "",
    "level_number"  => "",
    "next_level"    => "",
  );

  $vainkeur_entry = new WP_Query(array(
    'post_type'              => 'vainkeur',
    'posts_per_page'         => '1',
    'fields'                 => 'ids',
    'post_status'            => 'publish',
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => false,
    'meta_query'             => array(
      array(
        'key' => 'uuid_user_vkrz',
        'value' => $uuiduser,
        'compare' => '='
      )
    ),
  ));

  if ($vainkeur_entry->have_posts()) {

    $id_vainkeur    = $vainkeur_entry->posts[0];
    $nb_vote_vkrz   = get_field('nb_vote_vkrz', $id_vainkeur);
    $nb_top_vkrz    = get_field('nb_top_vkrz', $id_vainkeur);
    $money_vkrz     = get_field('money_vkrz', $id_vainkeur);
    $money_createur_vkrz = get_field('money_creator_vkrz', $id_vainkeur);
    $current_money_vkrz  = get_field('money_disponible_vkrz', $id_vainkeur);
  }

  if ($id_vainkeur) {

    $user_id         = get_post_field('post_author', $id_vainkeur);
    $user_info       = get_userdata($user_id);
    $user_pseudo     = $user_info->nickname;
    $user_email      = $user_info->user_email;
    $user_role       = $user_info->roles[0];
    $avatar_url      = get_avatar_url($user_id, ['size' => '80', 'force_default' => false]);
    $info_user_level = get_user_level($id_vainkeur);
  }

  return array(
    'id_vainkeur'       => $id_vainkeur,
    'user_id'           => $user_id,
    'uuid_user_vkrz'    => $uuiduser,
    'profil_url'        => get_author_posts_url($user_id),
    'pseudo'            => $user_pseudo,
    'avatar'            => $avatar_url,
    'user_email'        => $user_email,
    'user_role'         => $user_role,
    'level'             => $info_user_level['level_ico'],
    'level_number'      => $info_user_level['level_number'],
    'next_level'        => $info_user_level['next_level'],
    'nb_vote_vkrz'      => $nb_vote_vkrz,
    'nb_top_vkrz'       => $nb_top_vkrz,
    'money_vkrz'        => $money_vkrz,
    'money_creator_vkrz' => $money_createur_vkrz,
    'current_money_vkrz' => $current_money_vkrz
  );
}

function get_contender($data)
{
  $id_contender = $data['id_contender'];

  $the_query = new WP_Query(array(
    'p'         => $id_contender,
    'post_type' => 'contender'
  ));

  if ($the_query->have_posts()) {
    while ($the_query->have_posts()) : $the_query->the_post();
      return array(
        'Title'     => get_the_title(),
        'Thumbnail' => get_the_post_thumbnail_url()
      );
    endwhile;
  } else {
    echo 'No posts found.';
  }
  wp_reset_postdata();
}

function get_single_ranking($data)
{

  $list_ranking      = "";
  $id_ranking        = $data['id_ranking'];
  $user_ranking      = get_user_ranking($id_ranking);
  $total_rank        = array();

  $i = 1;
  foreach ($user_ranking as $c) :

    $list_ranking .= get_the_title($c) . " ";

    $i++;
  endforeach;

  array_push($total_rank, array(
    "classement" => $list_ranking,
  ));

  return $list_ranking;
}

function get_top_info($data)
{
  $id_top        = $data['id_top'];
  $top_datas     = get_top_infos($id_top);
  return $top_datas;
}

function add_contender_from_api()
{

  $id_visual   = $_GET['idphoto'];
  $url_visual  = $_GET['url_visual'];
  $pseudo      = $_GET['pseudo'];
  $id_top      = $_GET['id_top'];
  $email       = $_GET['email'];

  if ($id_visual) {

    $new_contender = array(
      'post_type'   => 'contender',
      'post_title'  => $pseudo,
      'post_status' => 'publish',
    );
    $id_new_contender  = wp_insert_post($new_contender);

    update_field('visuel_instagram_contender', $url_visual, $id_new_contender);
    update_field('id_tournoi_c', $id_top, $id_new_contender);
    update_field('email_contender', $email, $id_new_contender);
    update_field('ELO_c', '1200', $id_new_contender);

    if ($id_new_contender) {
      return "Nouveau contender dans le Top " . get_the_title($id_top);
    }
  }
}

function get_stats($data)
{
  $date = $data['date'];

  // TODAY'S DATE
  $today = date('d-m-Y');
  $todayFormatted = strtotime($today);
  global $whereTo, $quand;

  switch ($date) {
    case 'journalier':
      $whereTo = date("d-m-Y", strtotime("-1 day", $todayFormatted));
      $quand = 'Hier';
      break;
    case 'hebdo':
      $whereTo = date("d-m-Y", strtotime("-1 week", $todayFormatted));
      $quand = 'Une semaine avant';
      break;
    case 'mensu':
      $whereTo = date("d-m-Y", strtotime("-1 month", $todayFormatted));
      $quand = 'Un mois avant';
      break;
  }

  // COMPTE ENREGISTRE
  $args = array(
    'date_query' => array(
      array(
        'after'     => "$whereTo",
        'before'    => "$today",
        'inclusive' => true
      )
    )
  );
  $user_query = new WP_User_Query($args);
  $comptes = $user_query->get_total();

  // CLASSEMENT PUBLIE
  $args2 = array(
    'post_type' => 'classement',
    'date_query' => array(
      array(
        'after'     => "$whereTo",
        'before'    => "$today",
        'inclusive' => true
      )
    )
  );
  $query2 = new WP_Query($args2);
  $classements = $query2->found_posts;

  // CLASSEMENT NB VOTES
  $nb_classement_votes = 0;
  while ($query2->have_posts()) : $query2->the_post();
    $nb_classement_votes =  $nb_classement_votes + get_field('nb_votes_r');
  endwhile;

  // PLAYER PUBLIE
  $args3 = array(
    'post_type' => 'player',
    'date_query' => array(
      array(
        'after'     => "$whereTo",
        'before'    => "$today",
        'inclusive' => true
      )
    )
  );
  $query3 = new WP_Query($args3);
  $players = $query3->found_posts;

  $results = array(
    "Aujourd'hui" => date("d-m-Y", strtotime($today)),
    "$quand" => date("d-m-Y", strtotime($whereTo)),
    "Compte enregistre" => $comptes,
    "Classement publie" => $classements,
    "Player publie" => $players,
    "Classement NB votes" =>  $nb_classement_votes,
  );

  // $test = json_encode($results);

  return $results;
}
