<?php
function load_css_js()
{

  // CSS //

    // Icons
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/vendor/fonts/fontawesome.css', array(), null);
    wp_enqueue_style('tabler-icons', get_template_directory_uri() . '/assets/vendor/fonts/tabler-icons.css', array(), null);
    wp_enqueue_style('flag-icons', get_template_directory_uri() . '/assets/vendor/fonts/flag-icons.css', array(), null);

    // Core
    wp_enqueue_style('core', get_template_directory_uri() . '/assets/vendor/css/core-dark.css', array(), null);
    wp_enqueue_style('theme-default', get_template_directory_uri() . '/assets/vendor/css/rtl/theme-default-dark.css', array(), null);
    wp_enqueue_style('demo', get_template_directory_uri() . '/assets/vendor/css/rtl/demo.css', array(), null);

    // Vendor
    wp_enqueue_style('scrollbar', get_template_directory_uri() . '/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css', array(), null);
    wp_enqueue_style('waves', get_template_directory_uri() . '/assets/vendor/libs/node-waves/node-waves.css', array(), null);
    wp_enqueue_style('typeahead', get_template_directory_uri() . '/assets/vendor/libs/typeahead-js/typeahead.css', array(), null);
    wp_enqueue_style('datatables.bootstrap5', get_template_directory_uri() . '/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css', array(), null);
    wp_enqueue_style('responsive.bootstrap5', get_template_directory_uri() . '/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css', array(), null);
    wp_enqueue_style('buttons.bootstrap5', get_template_directory_uri() . '/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css', array(), null);
    wp_enqueue_style('select2', get_template_directory_uri() . '/assets/vendor/libs/select2/select2.css', array(), null);
    wp_enqueue_style('formValidation', get_template_directory_uri() . '/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css', array(), null);
    wp_enqueue_style('sweetalert2', get_template_directory_uri() . '/assets/vendor/libs/sweetalert2/sweetalert2.css', array(), null);
    wp_enqueue_style('spinkit', get_template_directory_uri() . '/assets/vendor/libs/spinkit/spinkit.css', array(), null);
    wp_enqueue_style('tagify', get_template_directory_uri() . '/assets/vendor/libs/tagify/tagify.css', array(), null);
    wp_enqueue_style('bootstrap-select', get_template_directory_uri() . '/assets/vendor/libs/bootstrap-select/bootstrap-select.css', array(), null);
    wp_enqueue_style('typeahead', get_template_directory_uri() . '/assets/vendor/libs/typeahead-js/typeahead.css', array(), null);

    if (is_page(array(27800, 27795, 27792, 27794, 443448))) {
      wp_enqueue_style('account', get_template_directory_uri() . '/assets/css/vkrz/login.css', array(), filemtime(get_template_directory() . '/assets/css/vkrz/login.css'));
    }

    // Fonts
    wp_enqueue_style('font', 'https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&?family=Libre%20Franklin:400?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), null);

    // Animate
    wp_enqueue_style('animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), null);

    // VAINKEURZ Custom
    wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/vkrz/main.css', array(), filemtime(get_template_directory() . '/assets/css/vkrz/main.css'));

  // SCRIPTS //

    // Users interractions
    if (isset($_COOKIE["wordpress_parrainage_cookies"]) && !empty($_COOKIE["wordpress_parrainage_cookies"])) {
      wp_enqueue_script('deal_parrainage', get_template_directory_uri() . '/function/firebase/deal_parrainage.js', array(), filemtime(get_template_directory() . '/function/firebase/deal_parrainage.js'), false);
    }

    // Helpers
    wp_enqueue_script('helpers', get_template_directory_uri() . '/assets/vendor/js/helpers.js', array(), null, false);
    wp_enqueue_script('config', get_template_directory_uri() . '/assets/js/config.js', array(), null, false);

    // Core
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/vendor/js/bootstrap.js', array(), null, true);
    wp_enqueue_script('popper', get_template_directory_uri() . '/assets/vendor/libs/popper/popper.js', array(), null, true);
    wp_enqueue_script('perfect-scrollbar', get_template_directory_uri() . '/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js', array(), null, true);
    wp_enqueue_script('node-waves', get_template_directory_uri() . '/assets/vendor/libs/node-waves/node-waves.js', array(), null, true);
    wp_enqueue_script('hammer', get_template_directory_uri() . '/assets/vendor/libs/hammer/hammer.js', array(), null, true);
    wp_enqueue_script('typeahead', get_template_directory_uri() . '/assets/vendor/libs/typeahead-js/typeahead.js', array(), null, true);
    wp_enqueue_script('menu', get_template_directory_uri() . '/assets/vendor/js/menu.js', array(), null, true);
    wp_enqueue_script('moment', get_template_directory_uri() . '/assets/vendor/libs/moment/moment.js', array(), null, true);
    wp_enqueue_script('jquery.dataTables', get_template_directory_uri() . '/assets/vendor/libs/datatables/jquery.dataTables.js', array(), null, true);
    wp_enqueue_script('datatables-bootstrap5', get_template_directory_uri() . '/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', array(), null, true);
    wp_enqueue_script('datatables.responsive', get_template_directory_uri() . '/assets/vendor/libs/datatables-responsive/datatables.responsive.js', array(), null, true);
    wp_enqueue_script('responsive.bootstrap5', get_template_directory_uri() . '/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js', array(), null, true);
    wp_enqueue_script('datatables-buttons', get_template_directory_uri() . '/assets/vendor/libs/datatables-buttons/datatables-buttons.js', array(), null, true);
    wp_enqueue_script('buttons.bootstrap5', get_template_directory_uri() . '/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.js', array(), null, true);
    wp_enqueue_script('buttons', get_template_directory_uri() . '/assets/vendor/libs/datatables-buttons/buttons.html5.js', array(), null, true);
    wp_enqueue_script('select2', get_template_directory_uri() . '/assets/vendor/libs/select2/select2.js', array(), null, true);
    wp_enqueue_script('formValidation', get_template_directory_uri() . '/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js', array(), null, true);
    wp_enqueue_script('bootstrap5', get_template_directory_uri() . '/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js', array(), null, true);
    wp_enqueue_script('autoFocus', get_template_directory_uri() . '/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js', array(), null, true);
    wp_enqueue_script('sweetalert2', get_template_directory_uri() . '/assets/vendor/libs/sweetalert2/sweetalert2.js', array(), null, true);
    wp_enqueue_script('mainthemejs', get_template_directory_uri() . '/assets/vendor/js/main.js', array(), null, true);
    wp_enqueue_script('bloodhound', get_template_directory_uri() . '/assets/vendor/libs/bloodhound/bloodhound.js', array(), null, true);
    wp_enqueue_script('typeahead-js', get_template_directory_uri() . '/assets/vendor/libs/typeahead-js/typeahead.js', array(), null, true);
    wp_enqueue_script('bootstrap-select', get_template_directory_uri() . '/assets/vendor/libs/bootstrap-select/bootstrap-select.js', array(), null, true);
    wp_enqueue_script('tagify-js', get_template_directory_uri() . '/assets/vendor/libs/tagify/tagify.js', array(), null, true);
    wp_enqueue_script('cleave', get_template_directory_uri() . '/assets/vendor/libs/cleavejs/cleave.js', array(), null, true);
    wp_enqueue_script('cleave-phone', get_template_directory_uri() . '/assets/vendor/libs/cleavejs/cleave-phone.js', array(), null, true);
    wp_enqueue_script('forms-selects', get_template_directory_uri() . '/assets/js/forms-selects.js', array(), null, true);
    wp_enqueue_script('forms-tagify', get_template_directory_uri() . '/assets/js/forms-tagify.js', array(), null, true);
    wp_enqueue_script('forms-typeahead', get_template_directory_uri() . '/assets/js/forms-typeahead.js', array(), null, true);

    // Twitch
    if (!isMobile() && is_user_logged_in() && get_userdata(get_user_logged_id())->twitch_user && get_post_type() == 'tournoi') {
      wp_enqueue_script('tmi.min', get_template_directory_uri() . '/function/twitch/tmi.min.js', array(), filemtime(get_template_directory() . '/function/twitch/tmi.min.js'), true);
      wp_enqueue_script('twitch_votes', get_template_directory_uri() . '/function/twitch/twitch_votes.js', array(), filemtime(get_template_directory() . '/function/twitch/twitch_votes.js'), true);
    }

    // Main VAINKEURE
    wp_enqueue_script('mainjs', get_template_directory_uri() . '/assets/js/main.js', array(), filemtime(get_template_directory() . '/assets/js/main.js'), true);
    
    wp_enqueue_script('filters', get_template_directory_uri() . '/assets/js/filters.js', array(), filemtime(get_template_directory() . '/assets/js/filters.js'), true);
    wp_enqueue_script('archive', get_template_directory_uri() . '/assets/js/archive.js', array(), filemtime(get_template_directory() . '/assets/js/archive.js'), true);

    // JS on specifik pages
    if (get_post_type() == 'toplist-mondiale') {
      wp_enqueue_script('set_comment_notification', get_template_directory_uri() . '/function/firebase/set_comment_notification.js', array(), filemtime(get_template_directory() . '/function/firebase/set_comment_notification.js'), true);
      wp_enqueue_script('calc_resemblance', get_template_directory_uri() . '/function/firebase/calc_resemblance.js', array(), filemtime(get_template_directory() . '/function/firebase/calc_resemblance.js'), true);
    }
    if (get_post_type() == "classement") {
      wp_enqueue_script('similar', get_template_directory_uri() . '/function/ajax/similar.js', array(), filemtime(get_template_directory() . '/function/ajax/similar.js'), true);
      wp_enqueue_script('toplist', get_template_directory_uri() . '/function/firebase/toplist.js', array(), filemtime(get_template_directory() . '/function/firebase/toplist.js'), true);
    }
    if (is_user_logged_in()) {
      wp_enqueue_script('get_menuuser_notifications', get_template_directory_uri() . '/function/firebase/get_menuuser_notifications.js', array(), filemtime(get_template_directory() . '/function/firebase/get_menuuser_notifications.js'), true);
    }
    if (is_page('Notifications')) {
      wp_enqueue_script('get_notifications_page', get_template_directory_uri() . '/function/firebase/get_notifications_page.js', array(), filemtime(get_template_directory() . '/function/firebase/get_notifications_page.js'), true);
    }
    if (is_page('Guetteur')) {
      wp_enqueue_script('get_friends_page', get_template_directory_uri() . '/function/firebase/get_friends_page.js', array(), filemtime(get_template_directory() . '/function/firebase/get_friends_page.js'), true);
    }
    if (is_author() || is_page(get_page_by_path('mon-compte'))) {
      wp_enqueue_script('fetch_toplist_by_vainkeur', get_template_directory_uri() . '/function/firebase/fetch_toplist_by_vainkeur.js', array(), filemtime(get_template_directory() . '/function/firebase/fetch_toplist_by_vainkeur.js'), true);
      wp_enqueue_script('follow_button', get_template_directory_uri() . '/function/firebase/follow_button.js', array(), filemtime(get_template_directory() . '/function/firebase/follow_button.js'), true);
    }
    if (is_page('Proposition de Tops')) {
      wp_enqueue_script('propositions', get_template_directory_uri() . '/function/firebase/propositions.js', array(), filemtime(get_template_directory() . '/function/firebase/propositions.js'), true);
    }
    if (is_page('Rechercher')) {
      wp_enqueue_script('recherches', get_template_directory_uri() . '/function/firebase/recherches.js', array(), filemtime(get_template_directory() . '/function/firebase/recherches.js'), true);
    }
    if (is_page(get_page_by_path('monitor'))) {
      wp_enqueue_script('monitor', get_template_directory_uri() . '/function/ajax/monitor.js', array(), filemtime(get_template_directory() . '/function/ajax/monitor.js'), true);
    }

    // VAINKEURZ Custom
    wp_enqueue_script('vainkeurz-table', get_template_directory_uri() . '/assets/js/vainkeurz-table.js', array(), filemtime(get_template_directory() . '/assets/js/vainkeurz-table.js'), true);
    if (is_single() && (get_post_type() == 'classement' || get_post_type() == 'tournoi')) {
      wp_enqueue_script('share', get_template_directory_uri() . '/assets/js/share.js', array(), filemtime(get_template_directory() . '/assets/js/share.js'), true);
    }
    if (is_single() && get_post_type() == 'tournoi') {
      wp_enqueue_script('contenders-ajax', get_template_directory_uri() . '/function/ajax/contenders-ajax.js', array(), filemtime(get_template_directory() . '/function/ajax/contenders-ajax.js'), true);
      wp_enqueue_script('begin', get_template_directory_uri() . '/function/ajax/begin-t.js', array(), filemtime(get_template_directory() . '/function/ajax/begin-t.js'), true);
    }
    wp_enqueue_script('meca', get_template_directory_uri() . '/function/ajax/meca.js', array(), filemtime(get_template_directory() . '/function/ajax/meca.js'), true);
    wp_enqueue_script('form', get_template_directory_uri() . '/function/ajax/form.js', array(), filemtime(get_template_directory() . '/function/ajax/form.js'), true);
    wp_enqueue_script('transaction', get_template_directory_uri() . '/function/ajax/transaction.js', array(), filemtime(get_template_directory() . '/function/ajax/transaction.js'), true);
}
add_action('wp_enqueue_scripts', 'load_css_js');
