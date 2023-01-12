<?php

function random_strings($length_of_string) 
{ 
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
    return substr(str_shuffle($str_result), 0, $length_of_string); 
} 

function generate_codeparrain($user_id){

    $randomString = random_strings(4);
    $uniquecode   = $user_id . $randomString;

    return $uniquecode;

}

function check_codeparrain($code)
{
    global $id_vainkeur;

    if ($code) {

        $user_query = new WP_User_Query(
            array(
                'number' => 1,
                'meta_query' => array(
                    array(
                        'key'     => 'code_parrain_user',
                        'value'   => $code,
                        'compare' => '='
                    )
                )
            )
        );
        $users = $user_query->get_results();

        foreach ($users as $user) {
            $user_id = $user->ID;
            $id_vainkeur = get_field('id_vainkeur_user', 'user_' . $user_id);
        }

        if($id_vainkeur != get_field('id_vainkeur_user', 'user_' . get_user_logged_id()))
            return $id_vainkeur;
        else 
            return false;
    }

}