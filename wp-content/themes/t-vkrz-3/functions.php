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

function delete_vainkeurz_cookie() {
  if (isset($_COOKIE["vainkeurz_id"]) && $_COOKIE["vainkeurz_id"] != "" && isset($_COOKIE["vainkeurz_uuid"]) && $_COOKIE["vainkeurz_uuid"] != "") {
    unset($_COOKIE["vainkeurz_id"]);
    setcookie("vainkeurz_id", "", time() - 3600, "/");
  
    unset($_COOKIE["vainkeurz_uuid"]);
    setcookie("vainkeurz_uuid", "", time() - 3600, "/");
  }
}
add_action('wp_logout', 'delete_vainkeurz_cookie');
