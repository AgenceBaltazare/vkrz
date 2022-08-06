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

function deal_vainkeurz_id_cookie($user_login, $user)
{
  // GET THE UUID…
  $uuiduser = get_field('uuiduser_user', 'user_' . $user->ID);

  // LOOK IN DATABASE FOR THE EXACT VAINKEURZ ID…
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
    )
  ));
  if ($vainkeur_entry->have_posts()) {
    $id_vainkeur = $vainkeur_entry->posts[0];

    // CLEAN VAINKEURZ_ID COOKIE FIRST…
    if (isset($_COOKIE["vainkeurz_id"]) && $_COOKIE["vainkeurz_id"] != "") {
      unset($_COOKIE["vainkeurz_id"]);
      setcookie("vainkeurz_id", "", time() - 3600, "/");
    }

    // FILL THE VAINKEURZ_ID COOKIE WITH THE EXACT ID…
    setcookie("vainkeurz_id", $id_vainkeur, time() + 31556926, "/");
  }
}
add_action('wp_login', 'deal_vainkeurz_id_cookie', 10, 2);

function delete_vainkeurz_cookie()
{
  if (isset($_COOKIE["vainkeurz_id"]) && $_COOKIE["vainkeurz_id"] != "" && isset($_COOKIE["vainkeurz_uuid"]) && $_COOKIE["vainkeurz_uuid"] != "") {
    unset($_COOKIE["vainkeurz_id"]);
    setcookie("vainkeurz_id", "", time() - 3600, "/");

    unset($_COOKIE["vainkeurz_uuid"]);
    setcookie("vainkeurz_uuid", "", time() - 3600, "/");
  }
}
add_action('wp_logout', 'delete_vainkeurz_cookie');
