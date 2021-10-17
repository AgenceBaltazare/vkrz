<?php
function form_newplayer($emailplayer, $uuiduser, $ranking){

    $url    = "https://hook.integromat.com/puo4c27s2ygviafkqhwrpydbx6klwlym";
    $args   = array(
        'body' => array(
            'email'             => $emailplayer,
            'date'              => date('d/m/Y'),
            'ranking'           => $ranking,
            'uuiduser'          => $uuiduser
        )
    );
    wp_remote_post($url, $args);

}
