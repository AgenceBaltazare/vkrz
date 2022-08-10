<?php
function load_css_js()
{

  $template_data       = wp_get_theme();
  $template_version    = $template_data['Version'];

  // CSS
  wp_enqueue_style('font', 'https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&?family=Libre%20Franklin:400&display=swap', array(), null);
  wp_enqueue_style('animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), null);
  wp_enqueue_style('vendors', get_template_directory_uri() . '/assets/css/core/vendors.min.css', array(), null);
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/core/bootstrap.min.css', array(), null);
  wp_enqueue_style('bootstrap-ext', get_template_directory_uri() . '/assets/css/core/bootstrap-extended.min.css', array(), null);
  wp_enqueue_style('theme', get_template_directory_uri() . '/assets/css/core/theme.css', array(), null);
  wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/core/swiper.min.css', array(), null);
  wp_enqueue_style('ext-swiper', get_template_directory_uri() . '/assets/css/core/ext-component-swiper.css', array(), null);
  wp_enqueue_style('ext-sweet-alerts', get_template_directory_uri() . '/assets/css/core/ext-component-sweet-alerts.css', array(), null);
  wp_enqueue_style('toastr', get_template_directory_uri() . '/assets/css/core/toastr.min.css', array(), null);
  wp_enqueue_style('ext-toastr', get_template_directory_uri() . '/assets/css/core/ext-component-toastr.min.css', array(), null);
  wp_enqueue_style('page-pricing', get_template_directory_uri() . '/assets/css/core/page-pricing.css', array(), null);
  wp_enqueue_style('vertical-menu', get_template_directory_uri() . '/assets/css/core/vertical-menu.css', array(), null);
  wp_enqueue_style('profil', get_template_directory_uri() . '/assets/css/core/page-profile.css', array(), null);

  if (is_page(array(27800, 27795, 27792, 27794, 443448))) {
    wp_enqueue_style('account', get_template_directory_uri() . '/assets/css/vkrz/login.css', array(), $template_version);
  }

  wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/vkrz/main.css', array(), $template_version);

  // Scripts
  
  // FOLLOW BUTTON…
  wp_enqueue_script('follow_button', get_template_directory_uri() . '/function/firebase/follow_button.js', array(), $template_version, true);

  wp_enqueue_script('popper', get_template_directory_uri() . '/assets/js/core/popper.min.js', array(), null, true);
  wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/core/bootstrap.min.js', array(), null, true);
  wp_enqueue_script('unison', get_template_directory_uri() . '/assets/js/core/unison-js.min.js', array(), null, true);
  wp_enqueue_script('feather', get_template_directory_uri() . '/assets/js/core/feather-icons.min.js', array(), null, true);
  wp_enqueue_script('perfectscrollbar', get_template_directory_uri() . '/assets/js/core/perfect-scrollbar.min.js', array(), null, true);
  wp_enqueue_script('waves', get_template_directory_uri() . '/assets/js/core/waves.min.js', array(), null, true);
  wp_enqueue_script('sweetalert', get_template_directory_uri() . '/assets/js/core/sweetalert2.all.min.js', array(), null, true);
  wp_enqueue_script('polyfill', get_template_directory_uri() . '/assets/js/core/polyfill.min.js', array(), null, true);
  wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/js/core/swiper.min.js', array(), null, true);
  wp_enqueue_script('component-swiper', get_template_directory_uri() . '/assets/js/core/ext-component-swiper.js', array(), null, true);
  wp_enqueue_script('component-toastr', get_template_directory_uri() . '/assets/js/core/toastr.min.js', array(), null, true);
  wp_enqueue_script('modals', get_template_directory_uri() . '/assets/js/core/components-modals.js', array(), null, true);
  wp_enqueue_script('app', get_template_directory_uri() . '/assets/js/core/app.js', array(), null, true);
  wp_enqueue_script('app-menu', get_template_directory_uri() . '/assets/js/core/app-menu.min.js', array(), null, true);
  wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/vkrz/main.js', array(), $template_version, true);

  if (is_single()) {
    wp_enqueue_script('contenders-ajax', get_template_directory_uri() . '/function/ajax/contenders-ajax.js', array(), $template_version, true);
  }
  if (is_single() && (get_post_type() == 'classement' || get_post_type() == 'tournoi')) {
    wp_enqueue_script('share', get_template_directory_uri() . '/assets/js/vkrz/share.js', array(), $template_version, true);
  }
  wp_enqueue_script('meca', get_template_directory_uri() . '/function/ajax/meca.js', array(), $template_version, true);
  wp_enqueue_script('begin', get_template_directory_uri() . '/function/ajax/begin-t.js', array(), $template_version, true);
  wp_enqueue_script('form', get_template_directory_uri() . '/function/ajax/form.js', array(), $template_version, true);
  wp_enqueue_script('transaction', get_template_directory_uri() . '/function/ajax/transaction.js', array(), $template_version, true);

  if (is_page(get_page_by_path('monitor'))) {
    wp_enqueue_script('monitor', get_template_directory_uri() . '/function/ajax/monitor.js', array(), $template_version, true);
  }
  if (is_author() || is_page('Notifications') || is_page('Guetteur') || is_page('Liste des Tops !') || is_page(array(284946, 143788, 284948, 218587)) || is_page(get_page_by_path('tas')) || is_page(get_page_by_path('mon-compte')) || is_page(get_page_by_path('mon-compte/createur'))) {
    wp_enqueue_script('datatables', get_template_directory_uri() . '/assets/js/core/datatable/datatables.min.js', array(), null, true);
    wp_enqueue_script('datatables-advanced', get_template_directory_uri() . '/assets/js/core/datatable/table-datatables-advanced.js', array(), null, true);
    wp_enqueue_script('datatables.buttons', get_template_directory_uri() . '/assets/js/core/datatable/datatables.buttons.min.js', array(), null, true);
    wp_enqueue_script('datatables.bootstrap', get_template_directory_uri() . '/assets/js/core/datatable/datatables.bootstrap4.min.js', array(), null, true);
    wp_enqueue_script('dataTables.responsive', get_template_directory_uri() . '/assets/js/core/datatable/dataTables.responsive.min.js', array(), null, true);
    wp_enqueue_script('responsive.bootstrap', get_template_directory_uri() . '/assets/js/core/datatable/responsive.bootstrap4.min.js', array(), null, true);
    wp_enqueue_script('vainkeurz-table', get_template_directory_uri() . '/assets/js/core/datatable/vainkeurz-table.js', array(), $template_version, true);
  }
  if (is_page_template("templates/elo-mondial.php")) {
    wp_enqueue_script('ranking', get_template_directory_uri() . '/function/ajax/ranking.js', array(), $template_version, true);
  }
  if (get_post_type() == "classement") {
    wp_enqueue_script('similar', get_template_directory_uri() . '/function/ajax/similar.js', array(), $template_version, true);

    wp_enqueue_script('toplist', get_template_directory_uri() . '/function/firebase/toplist.js', array(), $template_version, true);
  }

  // COMMENTS…
  if (is_page('Discuz')) {
    wp_enqueue_script('set_comment_notification', get_template_directory_uri() . '/function/firebase/set_comment_notification.js', array(), $template_version, true);
  }

  // MENU USER NOTIFICATIONS…
  if(is_user_logged_in()){
    wp_enqueue_script('get_menuuser_notifications', get_template_directory_uri() . '/function/firebase/get_menuuser_notifications.js', array(), $template_version, true);
  }

  // NOTIFICATIONS PAGE…
  if (is_page('Notifications')) {
    wp_enqueue_script('get_notifications_page', get_template_directory_uri() . '/function/firebase/get_notifications_page.js', array(), $template_version, true);
  }

  // FRIENDS PAGE…
  if (is_page('Guetteur')) {
    wp_enqueue_script('get_friends_page', get_template_directory_uri() . '/function/firebase/get_friends_page.js', array(), $template_version, true);
  }

  // USERS RANKS PAGE…
  if (is_page('Liste des Tops !')) {
    wp_enqueue_script('calc_resemblance', get_template_directory_uri() . '/function/firebase/calc_resemblance.js', array(), $template_version, true);
  }
}
add_action('wp_enqueue_scripts', 'load_css_js');
