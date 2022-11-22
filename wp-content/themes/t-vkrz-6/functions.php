<?php
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
include($templatepath . '/function/js-attribute.php');

@ini_set('upload_max_size', '64M');
@ini_set('post_max_size', '64M');
@ini_set('max_execution_time', '300');

function comment_redirect($location)
{
  if (isset($_POST['my_redirect_to'])) // Don't use "redirect_to", internal WP var
    $location = $_POST['my_redirect_to'];

  return $location;
}
add_filter('comment_post_redirect', 'comment_redirect');

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

add_theme_support('post-thumbnails');
add_filter(
  'the_excerpt',
  function ($excerpt) {
    return substr($excerpt, 0, strpos($excerpt, '.') + 1);
  }
);

function post_content($content)
{
  return preg_replace('/<p([^>]+)?>/', '<p$1 class="card-text my-2">', $content, 1);
}
add_filter('the_content', 'post_content');

function publish_top_to_discord($post_id){

  global $post;

  if($post->post_type != 'tournoi'){
      return;
  }

  $id_top             = $post_id;
  $top_infos_to_send  = get_top_infos($id_top);
  $top_title          = $top_infos_to_send['top_title'];
  $top_url            = get_the_permalink($id_top);
  $top_question       = $top_infos_to_send['top_question'];
  $top_visuel         = $top_infos_to_send['top_img'];
  foreach(get_the_terms($id_top, 'categorie') as $cat ) {
      $cat_id     = $cat->term_id;
      $cat_name   = $cat->name;
  }
  $cat_value          = get_field('icone_cat', 'term_'.$cat_id)." ".$cat_name;

  $creator_id         = get_post_field('post_author', $id_top);
  $creator_data       = get_user_by('ID', $creator_id);
  $creator_name       = $creator_data->nickname;
  $creator_img        = get_avatar_url($creator_id, ['size' => '80']);


  // 'body' => array(
  //     'top_title'     => $top_title,
  //     'top_visuel'    => $top_visuel,
  //     'top_url'       => $top_url,
  //     'top_question'  => $top_question,
  //     'top_autor_img' => $creator_img,
  //     'top_creator'   => $creator_name,
  //     'top_cat'       => $cat_value
  // )

  to_discord("newTop", "", "$creator_name", "$top_title", "$top_url");
}
add_action('publish_tournoi', 'publish_top_to_discord');