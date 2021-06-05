<?php
add_action('init', 'vkrz_head_cleanup');
function vkrz_head_cleanup() {
    remove_action( 'wp_head', 'feed_links_extra', 3 );
    remove_action( 'wp_head', 'feed_links', 2 );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'index_rel_link' );
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
    remove_action( 'wp_head', 'wp_generator' );
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', get_template_directory_uri().'/assets/vendors/js/jquery/jquery.min.js', array(), null, true);
    }
}

add_filter('the_generator', 'vkrz_rss_version');
function vkrz_rss_version() {
    return '';
}