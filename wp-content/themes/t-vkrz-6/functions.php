<?php
add_action('template_redirect', function () {
  ob_start();
});

add_filter( 'wppb_check_form_field_input', 'wppbc_custom_input_validation', 20, 4 );
function wppbc_custom_input_validation( $message, $field, $request_data, $form_location ){
	if( $field['field'] == 'Input' && $field['meta-name'] == 'referral' ){
		if ( isset( $request_data[$field['meta-name']] ) && trim( $request_data[$field['meta-name']] ) != '' ){
			$input = $request_data[$field['meta-name']];

      $referral_uuid  = get_field('uuid_user_vkrz', intval($input));
      $referral_infos = get_user_infos($referral_uuid);

      if(!$referral_infos['id_user']) {
        return "This Code Doesn't EXIST!";
      }

			// $possible_values = array('one' ,'two', 'three', 'four', 'five');
			// if( !in_array( $input, $possible_values) ) {
			// 	return 'You have entered an incorrect value for this field.';
			// }
		}
		if ( ( isset( $request_data[$field['meta-name']] ) && ( trim( $request_data[$field['meta-name']] ) == '' ) ) && ( $field['required'] == 'Yes' ) ){
			return wppb_required_field_error($field["field-title"]);
		}
	}
 
	return $message;
}

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