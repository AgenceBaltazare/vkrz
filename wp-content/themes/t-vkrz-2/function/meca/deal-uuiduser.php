<?php

function deal_uuiduser(){

    if(isset($_COOKIE["vainkeurz_user_id"]) && $_COOKIE["vainkeurz_user_id"] != ""){
        $uuiuser_cookie = $_COOKIE["vainkeurz_user_id"];
    }
    else{
        $uuiuser_cookie = uniqidReal();
    }

    if(is_user_logged_in()){

        $current_user   = wp_get_current_user();
        $user_id        = $current_user->ID;
        $uuiuser        = get_field('uuiduser_user', 'user_'.$user_id);

        if(isset($uuiuser) && $uuiuser != ""){

            $result = $uuiuser;

        }
        else{

            if(!isset($uuiuser_cookie) || $uuiuser_cookie == "") {

                $result = uniqidReal();

            }

            update_field('uuiduser_user', $uuiuser_cookie, 'user_' . $user_id);
            $result = $uuiuser_cookie;

        }

    }
    else{

        if(isset($uuiuser_cookie) && $uuiuser_cookie != "") {

            $result = $uuiuser_cookie;

        }
        else{

            $result = uniqidReal();

        }

    }

    setcookie("vainkeurz_user_id", $result, time()+31556926);
    return $result;

}