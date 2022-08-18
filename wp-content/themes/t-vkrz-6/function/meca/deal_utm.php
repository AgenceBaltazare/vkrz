<?php
function deal_utm(){

    $utm = "";

    if(isset($_GET['utm_campaign']) && $_GET['utm_campaign'] != ""){

        $utm = $_GET['utm_campaign'];

        setcookie("vainkeurz_user_utm", $utm, time()+31556926, "/");

    }

    return $utm;

}