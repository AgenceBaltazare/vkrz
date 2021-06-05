<?php
/*
    Template Name: Log off
*/
?>
<?php
if(is_user_logged_in()){
    setcookie("vainkeurz_user_id", "-", time(), "/");
    wp_logout();
    wp_redirect(get_bloginfo('url').'?logout=true');
    exit;
}
?>