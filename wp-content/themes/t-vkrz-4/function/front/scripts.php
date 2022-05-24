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

  wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/vkrz/main.css', array(), $template_version);

  // Scripts
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
  wp_enqueue_script('app', get_template_directory_uri() . '/assets/js/core/app.min.js', array(), null, true);
  wp_enqueue_script('app-menu', get_template_directory_uri() . '/assets/js/core/app-menu.min.js', array(), null, true);
  
  wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/vkrz/main.js', array(), $template_version, true);
}
add_action('wp_enqueue_scripts', 'load_css_js');
