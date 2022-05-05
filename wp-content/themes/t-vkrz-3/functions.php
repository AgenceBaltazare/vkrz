<?php

/**
 *
 * functions.php
 * Fichier de modification du comportement du WordPress
 *
 * Appel des fonctions selon l'utilisation : ajax, admin, front ou all
 * Inclure les fonctions à utiliser sur le projet dans le fichier correspondant function/
 * Inclure la fonction dans un fichier à son nom function/front/ ou function/admin/ ou function/ajax/
 *
 * Les fonctions récurentes sur les projets sont déjà dans les répertoires associés,
 * il faut décommenter leur appel dans le fichier associé dans function/
 *
 */
$templatepath = get_template_directory();

if (defined('DOING_AJAX') && DOING_AJAX && is_admin()) {

  include($templatepath . '/function/ajax.php');
} elseif (is_admin()) {

  include($templatepath . '/function/admin.php');
} elseif (!defined('XMLRPC_REQUEST') && !defined('DOING_CRON')) {

  include($templatepath . '/function/front.php');
}
include($templatepath . '/function/all.php');
include($templatepath . '/function/meca.php');
include($templatepath . '/function/tournament.php');
include($templatepath . '/function/data.php');
include($templatepath . '/function/webhook.php');
include($templatepath . '/function/api.php');

@ini_set('upload_max_size', '64M');
@ini_set('post_max_size', '64M');
@ini_set('max_execution_time', '300');

function wpse_58613_comment_redirect($location)
{
  if (isset($_POST['my_redirect_to'])) // Don't use "redirect_to", internal WP var
    $location = $_POST['my_redirect_to'];

  return $location;
}

add_filter('comment_post_redirect', 'wpse_58613_comment_redirect');
function oa_social_login_set_redirect_url($url, $user_data)
{
  if (isset($_GET['redirect']) && $_GET['redirect'] != "") {
    $url = $_GET['redirect'];
  } else {
    $url = get_site_url(null, '/mon-compte/');
  }
  return $url;
}
add_filter('oa_social_login_filter_registration_redirect_url', 'oa_social_login_set_redirect_url', 10, 2);
add_filter('oa_social_login_filter_login_redirect_url', 'oa_social_login_set_redirect_url', 10, 2);


function top_published_notification()
{
  /*
  $id_user 
  $uuiduser 
  $relation_id 
  $relation_uuid 
  $notif_text 
  $liens_vers
  */

  $id_user = get_user_logged_id();
  $uuiduser = get_field('uuiduser_user', 'user_' . $id_user);

  $actual_user_infos = get_user_infos($uuiduser);

  $amis_ids = array();
  $amis_ids = get_field('liste_amis_user', 'user_' . $id_user, false);
  if (is_array($amis_ids)) {
    $amis = array();
    foreach ($amis_ids as $ami_id) :
      $ami_uuid = get_field('uuiduser_user', 'user_' . $ami_id);
      $ami_infos = get_user_infos($ami_uuid);

      array_push($amis, $ami_infos);
    endforeach;
  }

  $user = wp_get_current_user();
  $user_name = $user->display_name;

  $notif_text = $user_name . ' viens de lancer un Top!';
  $liens_vers = 'https://www.google.com/';


  foreach ($amis as $ami) {
    do_notification($id_user, $uuiduser, $ami['user_id'], $ami['uuid_user_vkrz'], $notif_text, $liens_vers);
  }
}
add_action('publish_tournoi', 'top_published_notification', 10, 2);
