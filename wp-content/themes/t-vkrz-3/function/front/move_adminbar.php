<?php
function remove_admin_login_header() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_login_header');

function move_admin_bar() {
        echo '
    <style type="text/css">
    html {
    margin-top: 0 !important;
    }
    body.admin-bar #wphead {padding-top: 0;}
    body.admin-bar #footer {padding-bottom: 28px;}
    #wpadminbar { top: auto !important;bottom: 0;}
    #wpadminbar .quicklinks .menupop ul { bottom: 28px;}
    </style>';
}
//add_action( 'wp_head', 'move_admin_bar' );