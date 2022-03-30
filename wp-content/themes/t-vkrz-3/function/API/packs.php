<?php
require_once('fct.php');

function add_contender_from_api()
{

  $id_visual   = $_GET['idphoto'];
  $url_visual  = $_GET['url_visual'];
  $pseudo      = $_GET['pseudo'];
  $id_top      = $_GET['id_top'];

  if ($id_visual) {

    $new_contender = array(
      'post_type'   => 'contender',
      'post_title'  => $pseudo,
      'post_status' => 'publish',
    );
    $id_new_contender  = wp_insert_post($new_contender);

    update_field('visuel_instagram_contender', $url_visual, $id_new_contender);
    update_field('id_tournoi_c', $id_top, $id_new_contender);
    update_field('ELO_c', '1200', $id_new_contender);

    if ($id_new_contender) {
      return "Nouveau contender dans le Top " . get_the_title($id_top);
    }
  }
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

function get_info()
{
  $today = date('d-m-Y');
  $todayFormatted = strtotime($today);
  $tomorrow = date("d-m-Y", strtotime("+1 day", $todayFormatted));

  $args = array(
    'date_query' => array(
      array(
        'after'     => "$today",
        'before'    => "$tomorrow",
        'inclusive' => true
      )
    )
  );
  $user_query = new WP_User_Query($args);
  $comptes = $user_query->get_total();

  $args2 = array(
    'post_type' => 'classement',
    'date_query' => array(
      array(
        'after'     => "$today",
        'before'    => "$tomorrow",
        'inclusive' => true
      )
    )
  );
  $query2 = new WP_Query($args2);
  $classements = $query2->found_posts;

  $args3 = array(
    'post_type' => 'player',
    'date_query' => array(
      array(
        'after'     => "$today",
        'before'    => "$tomorrow",
        'inclusive' => true
      )
    )
  );
  $query3 = new WP_Query($args3);
  $players = $query3->found_posts;


  $results = array(
    "KPI'S" => date("d/m/Y", strtotime($today)),
    "Compte enregistré" => $comptes,
    "Classement publié" => $classements,
    "Player publié" => $players,
  );

  // $test = json_encode($results);

  return $results;
}
