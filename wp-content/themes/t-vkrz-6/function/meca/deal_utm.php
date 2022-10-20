<?php
function deal_utm(){

    $utm = "";

    if(isset($_GET['utm_campaign']) && $_GET['utm_campaign'] != ""){

        $utm = $_GET['utm_campaign'];

        $arr_cookie_options = array(
            'expires' => time() + 60 * 60 * 24 * 365,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => false,
            'samesite' => 'Lax'
        );

        setcookie("wordpress_vainkeurz_user_utm", $utm, $arr_cookie_options);

    }

    return $utm;

}