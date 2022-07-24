<?php
function deal_uuiduser(){

    $uuiuser = false;
    
    if(is_user_logged_in()){

        global $user_id;
        $user_id    = get_user_logged_id();
        $uuiuser    = get_field('uuiduser_user', 'user_'.$user_id);

        if (isset($uuiuser) && !empty($uuiuser)) {
            $result = $uuiuser;
        } else {
            if (isset($_COOKIE["vainkeurz_uuid"]) && $_COOKIE["vainkeurz_uuid"] != "") {
                $result = $_COOKIE["vainkeurz_uuid"];
            } else {
                $result = uniqidReal();
            }

            update_field('uuiduser_user', $result, 'user_' . $user_id);
        }

        if($_COOKIE["vainkeurz_uuid"] != $uuiuser){
            setcookie("vainkeurz_uuid", $uuiuser, time() + 31556926, "/");
        }
    } else {

        if(isset($_COOKIE["vainkeurz_uuid"]) && $_COOKIE["vainkeurz_uuid"] != ""){
            $result = $_COOKIE["vainkeurz_uuid"];
        }
        else{
            $result = uniqidReal();
        }

    }

    if (!isset($_COOKIE['vainkeurz_uuid']) || empty($_COOKIE["vainkeurz_uuid"])) {
        setcookie("vainkeurz_uuid", $result, time()+31556926, "/");
    }

    return $result;
}
