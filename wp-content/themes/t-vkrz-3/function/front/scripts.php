<?php
function load_css_js() {

    $template_data       = wp_get_theme();
    $template_version    = $template_data['Version'];

    // CSS
    wp_enqueue_style('font', 'https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&?family=Libre%20Franklin:400&display=swap', array(), null);
    wp_enqueue_style('animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), null);
    wp_enqueue_style('vendors', get_template_directory_uri().'/assets/vendors/css/vendors.min.css', array(), null);
    wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/css/bootstrap.min.css', array(), null);
    wp_enqueue_style('bootstrap-ext', get_template_directory_uri().'/assets/css/bootstrap-extended.min.css', array(), null);
    wp_enqueue_style('theme', get_template_directory_uri().'/assets/css/theme/theme.css', array(), null);
    wp_enqueue_style('swiper', get_template_directory_uri().'/assets/vendors/css/extensions/swiper.min.css', array(), null);
    wp_enqueue_style('ext-swiper', get_template_directory_uri().'/assets/css/plugins/extensions/ext-component-swiper.css', array(), null);
    wp_enqueue_style('ext-sweet-alerts', get_template_directory_uri().'/assets/css/plugins/extensions/ext-component-sweet-alerts.css', array(), null);
    wp_enqueue_style('page-pricing', get_template_directory_uri().'/assets/css/pages/page-pricing.css', array(), null);
    wp_enqueue_style('vertical-menu', get_template_directory_uri().'/assets/css/theme/vertical-menu.css', array(), null);
    if(get_post_type() == "tournoi"){
        wp_enqueue_style('chat', get_template_directory_uri().'/assets/css/pages/app-chat-list.min.css', array(), null);
    }
    wp_enqueue_style('main', get_template_directory_uri().'/assets/css/vkrz/main.css', array(), $template_version);

    // Scripts
    wp_enqueue_script('fontawesome', 'https://kit.fontawesome.com/30edd5507e.js', array(), null, true);
    wp_enqueue_script('popper', get_template_directory_uri().'/assets/vendors/js/popper/popper.min.js', array(), null, true);
    wp_enqueue_script('bootstrap', get_template_directory_uri().'/assets/vendors/js/bootstrap/bootstrap.min.js', array(), null, true);
    wp_enqueue_script('unison', get_template_directory_uri().'/assets/vendors/js/unison-js/unison-js.min.js', array(), null, true);
    wp_enqueue_script('feather', get_template_directory_uri().'/assets/vendors/js/feather-icons/feather-icons.min.js', array(), null, true);
    wp_enqueue_script('perfectscrollbar', get_template_directory_uri().'/assets/vendors/js/perfectscrollbar/perfect-scrollbar.min.js', array(), null, true);
    wp_enqueue_script('waves', get_template_directory_uri().'/assets/vendors/js/waves/waves.min.js', array(), null, true);
    wp_enqueue_script('sweetalert', get_template_directory_uri().'/assets/vendors/js/extensions/sweetalert2.all.min.js', array(), null, true);
    wp_enqueue_script('polyfill', get_template_directory_uri().'/assets/vendors/js/extensions/polyfill.min.js', array(), null, true);
    wp_enqueue_script('swiper', get_template_directory_uri().'/assets/vendors/js/extensions/swiper.min.js', array(), null, true);
    wp_enqueue_script('component-swiper', get_template_directory_uri().'/assets/js/scripts/extensions/ext-component-swiper.js', array(), null, true);
    wp_enqueue_script('modals', get_template_directory_uri().'/assets/js/scripts/components/components-modals.js', array(), null, true);
    wp_enqueue_script('app', get_template_directory_uri().'/assets/js/core/app.js', array(), null, true);
    wp_enqueue_script('app-menu', get_template_directory_uri().'/assets/js/core/app-menu.js', array(), null, true);
    wp_enqueue_script('main', get_template_directory_uri().'/assets/js/core/main.js', array(), $template_version, true);
    wp_enqueue_script('contenders-ajax', get_template_directory_uri().'/function/ajax/contenders-ajax.js', array(), $template_version, true);
    wp_enqueue_script('meca', get_template_directory_uri().'/function/ajax/meca.js', array(), $template_version, true);
    wp_enqueue_script('note', get_template_directory_uri().'/function/ajax/note-t.js', array(), $template_version, true);
    wp_enqueue_script('begin', get_template_directory_uri().'/function/ajax/begin-t.js', array(), $template_version, true);
}
add_action('wp_enqueue_scripts', 'load_css_js');