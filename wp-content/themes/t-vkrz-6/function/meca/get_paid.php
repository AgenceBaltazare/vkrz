<?php
function get_paid($nb_votes) {

    $money = round($nb_votes / 1000);

    return $money;

}