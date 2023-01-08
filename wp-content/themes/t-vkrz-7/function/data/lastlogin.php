<?php
function user_last_login($user_login, $user){
    update_user_meta($user->ID, 'last_login', time());
}
add_action('wp_login', 'user_last_login', 10, 2);

function wpb_lastlogin(){
    $last_login = get_the_author_meta('last_login');
    $the_login_date = human_time_diff($last_login);
    return $the_login_date;
}