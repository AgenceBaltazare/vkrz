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
  $user = wp_get_current_user();
  $user_name = $user->display_name;

  $liens_vers = "";
  $author = "";
  $post_author_id = "";

  $last_tournoi = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'tournoi',
    'post_status'            => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => 1,
    'tax_query'              => array(
      'author_name'          => $user_name
    )
  ));
  while ($last_tournoi->have_posts()) : $last_tournoi->the_post();
    $liens_vers = get_the_ID();
    $author = the_author();
    $post_author_id = get_post_field('post_author', get_the_ID());
  endwhile;

  if ($post_author_id) {
    $id_user = $post_author_id;
    $uuiduser = get_field('uuiduser_user', 'user_' . $id_user);

    $amis_ids = array();
    $amis_ids = get_field('liste_amis_user', 'user_' . $id_user, false);
    if (is_array($amis_ids)) {
      $amis = array();
      foreach (array_unique($amis_ids) as $ami_id) :
        $ami_uuid = get_field('uuiduser_user', 'user_' . $ami_id);
        $ami_infos = get_user_infos($ami_uuid);

        array_push($amis, $ami_infos);
      endforeach;
    }

    $notif_text = $author . ' viens de lancer un Top!';

    foreach ($amis as $ami) {
      do_notification($id_user, $uuiduser, $ami['user_id'], $ami['uuid_user_vkrz'], $notif_text, $liens_vers);
    }
  }
}
// add_action('publish_tournoi', 'top_published_notification', 10, 2);

function classement_published_notification()
{
  $user = wp_get_current_user();
  $user_name = $user->display_name;
  $user_id = $user->ID;

  $uuiduser = get_field('uuiduser_user', 'user_' . $user_id);

  $amis_ids = array();
  $amis_ids = get_field('liste_amis_user', 'user_' . $user_id, false);
  if (is_array($amis_ids)) {
    $amis = array();
    foreach (array_unique($amis_ids) as $ami_id) :
      $ami_uuid = get_field('uuiduser_user', 'user_' . $ami_id);
      $ami_infos = get_user_infos($ami_uuid);

      array_push($amis, $ami_infos);
    endforeach;
  }

  $notif_text = $user_name  . ' a fait un nouveau Classement!';
  $liens_vers = '';

  foreach ($amis as $ami) {
    do_notification($user_id, $uuiduser, $ami['user_id'], $ami['uuid_user_vkrz'], $notif_text, $liens_vers);
  }
}
// add_action('publish_classement', 'classement_published_notification', 10, 2);
