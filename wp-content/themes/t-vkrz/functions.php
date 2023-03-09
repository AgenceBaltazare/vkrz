<?php
add_action('template_redirect', function () {
  ob_start();
});
add_filter( 'wppb_check_form_field_input', 'wppbc_custom_input_validation', 20, 4 );
function wppbc_custom_input_validation( $message, $field, $request_data, $form_location ){
	if( $field['field'] == 'Input' && $field['meta-name'] == 'referral' ){
		if ( isset( $request_data[$field['meta-name']] ) && trim( $request_data[$field['meta-name']] ) != '' ){
			$input = $request_data[$field['meta-name']];
      if(!check_codeparrain($input)) {
        return "Aucun parrain trouvé";
      } 
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

function publish_top_to_discord($post_id){

  global $post;

  if($post->post_type != 'tournoi' || $post->post_status == 'publish'){
      return;
  }
  $post_taxonomies = array();
  foreach(get_the_terms($post_id, 'type') as $tax ) {
    array_push($post_taxonomies, $tax->name);
  }
  if(in_array("Private", $post_taxonomies)) {
    return;
  }

  $id_top             = $post_id;
  $top_infos_to_send  = get_top_infos($id_top);
  $top_title          = $top_infos_to_send['top_title'];

  foreach(get_the_terms($id_top, 'categorie') as $cat ) {
    $cat_name   = $cat->name;

  }
  switch ($cat_name) {
    case 'Sport':
      $cat_icon = " 🏓 ";
      break; 
    case 'Musique':
      $cat_icon = " 💿 ";
      break;
    case 'Jeux vidéo':
      $cat_icon = " 🕹️ ";
      break;
    case 'Food':
      $cat_icon = " 🥨 ";
      break;
    case 'Écran':
      $cat_icon = " 📺 ";
      break;
    case 'Comics':
      $cat_icon = " 🕸️ ";
      break;
    case 'Manga':
      $cat_icon = " 🐲 ";
      break;
    case 'Autres':
      $cat_icon = " ⚔️ ";
      break;

    default: 
      $cat_icon = " : ";
  }

  $top_full_title     = "TOP " . $top_infos_to_send['top_number'] . $cat_icon . $top_title;
  $top_url            = get_the_permalink($id_top);
  $top_question       = $top_infos_to_send['top_question'];
  $top_question       = str_replace("'", "&rsquo;", $top_question);
  $top_visuel         = $top_infos_to_send['top_img'];

  $creator_id         = get_post_field('post_author', $id_top);
  $creator_data       = get_user_by('ID', $creator_id);
  $creator_name       = $creator_data->nickname;
  $creator_img        = get_avatar_url($creator_id, ['size' => '80']);

  $data = (object) [
      'top_title'      => $top_title,
      'top_full_title' => $top_full_title,
      'top_visuel'     => $top_visuel,
      'top_url'        => $top_url,
      'top_question'   => $top_question,
      'cat_name'       => $cat_name,
      'top_author_img' => $creator_img,
      'top_creator'    => $creator_name,
      'top_author_url' => esc_url(get_author_posts_url($creator_id))
  ];

  $data = json_encode($data);

  // to_discord("newTop", $data);

  system("/usr/local/bin/node ./index.js '/discord' 'newTop' '$data'"); 
}
add_action('publish_tournoi', 'publish_top_to_discord');

function divi_engine_move_admin_bar_bottom() {
  echo '<style>
  body {
  margin-top: -28px;
  padding-bottom: 28px;
  }
  body.admin-bar #wphead {
     padding-top: 0;
  }
  body.admin-bar #footer {
     padding-bottom: 28px;
  }
  #wpadminbar {
      top: auto !important;
      bottom: 0;
  }
  #wpadminbar .quicklinks .menupop ul {
      bottom: 28px;
  }
  </style>';
}
add_action( 'admin_head', 'divi_engine_move_admin_bar_bottom' );
add_action( 'wp_head', 'divi_engine_move_admin_bar_bottom' );

function add_subscriber_post_capabilities() {
  $role = get_role( 'subscriber' );
  $role->add_cap( 'create_posts' );
}
add_action( 'admin_init', 'add_subscriber_post_capabilities' );
