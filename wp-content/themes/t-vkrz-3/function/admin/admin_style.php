<?php
function admin_style() {

    $current_user    = wp_get_current_user();
    $user_id         = $current_user->ID;
    $user_info       = get_userdata($user_id);
    $user_role       = $user_info->roles[0];

    if($user_role == "author"){
        wp_enqueue_style('author-styles', get_template_directory_uri().'/assets/css/admin/panel-author.css');
    }
    wp_enqueue_style('admin-styles', get_template_directory_uri().'/assets/css/admin/panel.css');
}
add_action('admin_enqueue_scripts', 'admin_style');