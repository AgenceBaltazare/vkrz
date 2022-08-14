<?php
require_once('fct.php');

function get_user_infos_from_api($data){

  $uuid_vainkeur = $data['uuiduser'];
  return get_user_infos($uuid_vainkeur, "complete");
  
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

function get_all_toplist_by_id_top($data)
{

  $results              = array();
  $id_top               = $data['id_top'];
  $id_resume            = get_resume_id($id_top);
  $list_toplist         = json_decode(get_field('all_toplist_resume', $id_resume));
  $list_toplist         = array_reverse($list_toplist);
  
  foreach ($list_toplist as $id_ranking) :
    $uuiduser                = get_field('uuid_user_r', $id_ranking);
    $vainkeur_infos          = get_user_infos($uuiduser);

    if ($vainkeur_infos['user_role'] != "anonyme") :
      $user_top3    = get_user_ranking($id_ranking, 3);

      foreach($user_top3 as $contender){
        $list_podium []= array(
          'id_contender'      => $contender,
          'nom_contender'     => get_the_title($contender),
          'visuel_contender'  => get_the_post_thumbnail_url($contender, 'thumbnail'),
        );
      }
      $results    []= array(
        $vainkeur_infos['pseudo'],
        $list_podium[0]['nom_contender'],
        get_the_permalink($id_ranking),
      );
    endif;
  endforeach;

  return array(
    'data' => $results
  );
}


function get_all_toplist_by_id_top_archive($data)
{

  $results              = array();
  $id_top               = $data['id_top'];
  $id_resume            = get_resume_id($id_top);
  $list_toplist         = json_decode(get_field('all_toplist_resume', $id_resume));
  $list_toplist         = array_reverse($list_toplist);

  foreach ($list_toplist as $id_ranking) :
    $uuiduser                = get_field('uuid_user_r', $id_ranking);
    $vainkeur_infos          = get_user_infos($uuiduser);

    if ($vainkeur_infos['user_role'] != "anonyme") :
      $user_top3    = get_user_ranking($id_ranking, 3);

      foreach ($user_top3 as $contender) {
        $list_podium[] = array(
          'id_contender'      => $contender,
          'nom_contender'     => get_the_title($contender),
          'visuel_contender'  => get_the_post_thumbnail_url($contender, 'thumbnail'),
        );
      }
      $results[] = array(
        'vainkeur'      => $vainkeur_infos,
        'podium'        => $list_podium,
        'toplist_url'   => get_the_permalink($id_ranking),
      );
    endif;
  endforeach;

  return $results;
}