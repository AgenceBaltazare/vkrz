<?php
function custom_login_css(){
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/assets/css/admin/lecentre.css" />';
}
add_action('login_head', 'custom_login_css');

function custom_title_login($message) {
    return get_bloginfo('description');
}
add_filter('login_headertitle', 'custom_title_login');