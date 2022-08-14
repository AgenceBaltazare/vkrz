<?php

function delete_old_cookies(){

    $reponse_delete = "not clear";

    if(isset($_COOKIE["user_was_logged_cookie"]) && $_COOKIE["user_was_logged_cookie"] != "" && !is_user_logged_in()){
        delete_vainkeurz_cookies();
        $reponse_delete = "clear";
    }

    return $reponse_delete;

}

function generate_vainkeurz_cookies($user_login, WP_User $user){

    $arr_cookie_options = array(
        'expires' => time() + 60 * 60 * 24 * 365,
        'path' => '/',
        'domain' => '.vainkeurz.com',
        'secure' => true,
        'httponly' => false,
        'samesite' => 'Lax'
    );

    $user_id        = $user->ID;

    if(get_field('uuiduser_user', 'user_' . $user_id)){

        setcookie("vainkeurz_uuid_cookie", get_field('uuiduser_user', 'user_' . $user_id), $arr_cookie_options);

    }

    if (get_field('id_vainkeur_user', 'user_' . $user_id)) {

        setcookie("vainkeurz_id_cookie", get_field('id_vainkeur_user', 'user_' . $user_id), $arr_cookie_options);

    }

    setcookie("user_was_logged_cookie", date("Y-m-d H:i:s"), $arr_cookie_options);

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