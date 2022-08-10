<?php

function delete_old_cookies(){

    if(isset($_COOKIE["user_was_logged_cookie"]) && $_COOKIE["user_was_logged_cookie"] != "" && !is_user_logged_in()){
        delete_vainkeurz_cookies();
    }

}

function generate_vainkeurz_cookies($user_login, WP_User $user){

    $user_id        = $user->ID;

    if(get_field('uuiduser_user', 'user_' . $user_id)){

        setcookie("vainkeurz_uuid_cookie", get_field('uuiduser_user', 'user_' . $user_id), time() + 31556926, "/");

    }

    if (get_field('id_vainkeur_user', 'user_' . $user_id)) {

        setcookie("vainkeurz_id_cookie", get_field('id_vainkeur_user', 'user_' . $user_id), time() + 31556926, "/");

    }

    setcookie("user_was_logged_cookie", date("Y-m-d H:i:s"), time() + 31556926, "/");

}
add_action('wp_login', 'generate_vainkeurz_cookies', 10, 2);


function delete_vainkeurz_cookies()
{
    if (isset($_COOKIE["vainkeurz_id_cookie"]) && $_COOKIE["vainkeurz_id_cookie"] != "") {
        unset($_COOKIE["vainkeurz_id_cookie"]);
        setcookie("vainkeurz_id_cookie", "", time() - 3600, "/");
    }

    if (isset($_COOKIE["vainkeurz_uuid_cookie"]) && $_COOKIE["vainkeurz_uuid_cookie"] != "") {
        unset($_COOKIE["vainkeurz_uuid_cookie"]);
        setcookie("vainkeurz_uuid_cookie", "", time() - 3600, "/");
    }
    
    if (isset($_COOKIE["vainkeur_ready_to_be_create_cookie"]) && $_COOKIE["vainkeur_ready_to_be_create_cookie"] != "") {
        unset($_COOKIE["vainkeur_ready_to_be_create_cookie"]);
        setcookie("vainkeur_ready_to_be_create_cookie", "", time() - 3600, "/");
    }
    
    if (isset($_COOKIE["user_was_logged_cookie"]) && $_COOKIE["user_was_logged_cookie"] != "") {
        unset($_COOKIE["user_was_logged_cookie"]);
        setcookie("user_was_logged_cookie", "", time() - 3600, "/");
    }
}
add_action('wp_logout', 'delete_vainkeurz_cookies');