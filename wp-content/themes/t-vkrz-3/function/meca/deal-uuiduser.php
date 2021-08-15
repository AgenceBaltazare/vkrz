<?php
function deal_uuiduser(){

    if(is_user_logged_in()){

        global $user_id;

        $uuiuser        = get_field('uuiduser_user', 'user_'.$user_id);

        if(isset($uuiuser) && $uuiuser != ""){

            $result = $uuiuser;

        }
        else{

            if(isset($_COOKIE["vainkeurz_user_id"]) && $_COOKIE["vainkeurz_user_id"] != ""){
                $result = $_COOKIE["vainkeurz_user_id"];
            }
            else{
                $result = uniqidReal();
            }

            update_field('uuiduser_user', $result, 'user_' . $user_id);

        }

    }
    else{

        if(isset($_COOKIE["vainkeurz_user_id"]) && $_COOKIE["vainkeurz_user_id"] != ""){
            $result = $_COOKIE["vainkeurz_user_id"];
        }
        else{
            $result = uniqidReal();
        }

    }

    setcookie("vainkeurz_user_id", $result, time()+31556926, "/");

    return $result;

}