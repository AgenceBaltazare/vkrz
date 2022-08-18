<?php
/*
    Template Name: Log off
*/
if(is_user_logged_in()){
    wp_logout();
    wp_redirect(get_bloginfo('url').'?logout=true');
    exit;
}
?>