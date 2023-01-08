<?php
function lwp_2610_custom_author_base() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'v';
}
add_action( 'init', 'lwp_2610_custom_author_base' );