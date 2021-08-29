<?php
function add_theme_caps() {
    $admins = get_role( 'administrator' );
    $admins->add_cap( 'publish_tops');
    $admins->add_cap( 'edit_tops' ); 
    $admins->add_cap( 'read_top' ); 
    $admins->add_cap( 'delete_tops' ); 
    $admins->add_cap( 'edit_others_tops' ); 
    $admins->add_cap( 'read_private_tops' );
    $admins->remove_cap( 'fdsfdsfdsf' );
    $admins->remove_cap( 'publish_tournois' );

    $authors = get_role( 'author' );
    $authors->add_cap( 'publish_tops', false);
    $authors->add_cap( 'edit_tops' ); 
    $authors->add_cap( 'read_top' ); 
    $authors->add_cap( 'delete_tops' ); 
    $authors->add_cap( 'edit_others_tops', false); 
    $authors->add_cap( 'read_private_tops', false);

    wp_roles()->remove_role('editor');
}
add_action('admin_init', 'add_theme_caps');

add_action('admin_init', 'disable_dashboard');
function disable_dashboard() {
    if (current_user_can('subscriber') && is_admin()) {
        wp_redirect(home_url());
        exit;
    }
}