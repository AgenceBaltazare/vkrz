<?php
function check_user_level($id_vainkeur){

    $user_id        = get_user_logged_id();
    $level_up       = false;

    if($user_id){

        $niv_1 = 50;
        $niv_2 = 500;
        $niv_3 = 2000;
        $niv_4 = 5000;
        $niv_5 = 35000;
        $niv_6 = 100000;
        $niv_7 = 450000;
        $niv_8 = 1000000;

        $user_vote_counter  = get_field('nb_vote_vkrz', $id_vainkeur);
        $user_level         = get_field('level_user', 'user_' . $user_id);
            
        switch($user_vote_counter){
            case $user_vote_counter < $niv_1 :
                $level          = '<span class="va va-z-20 va-egg"></span>';
                $level_number   = 0;
                $next_level     = '<span class="va va-z-20 va-hatching-chick"></span>';
                break;
            case $niv_1 <= $user_vote_counter && $user_vote_counter < $niv_2 :
                $level          = '<span class="va va-z-20 va-hatching-chick"></span>';
                $level_number   = 1;
                $next_level     = '<span class="va va-z-20 va-chick"></span>';
                break;
            case $niv_2 <= $user_vote_counter && $user_vote_counter < $niv_3 :
                $level          = '<span class="va va-z-20 va-chick"></span>';
                $level_number   = 2;
                $next_level     = '<span class="va va-z-20 va-rooster"></span>';
                break;
            case $niv_3 <= $user_vote_counter && $user_vote_counter < $niv_4 :
                $level          = '<span class="va va-z-20 va-rooster"></span>';
                $level_number   = 3;
                $next_level     = '<span class="va va-z-20 va-turkey"></span>';
                break;
            case $niv_4 <= $user_vote_counter && $user_vote_counter < $niv_5 :
                $level          = '<span class="va va-z-20 va-turkey"></span>';
                $level_number   = 4;
                $next_level     = '<span class="va va-z-20 va-swan"></span>';
                break;
            case $niv_5 <= $user_vote_counter && $user_vote_counter < $niv_6 :
                $level          = '<span class="va va-z-20 va-swan"></span>';
                $level_number   = 5;
                $next_level     = '<span class="va va-z-20 va-flamingo"></span>';
                break;
            case $niv_6 <= $user_vote_counter && $user_vote_counter < $niv_7 :
                $level          = '<span class="va va-z-20 va-flamingo"></span>';
                $level_number   = 6;
                $next_level     = '<span class="va va-z-20 va-peacock"></span>';
                break;
            case $niv_7 <= $user_vote_counter && $user_vote_counter < $niv_8 :
                $level          = '<span class="va va-z-20 va-peacock"></span>';
                $level_number   = 7;
                $next_level     = '<span class="va va-z-20 va-dragon"></span>';
                break;
            case $niv_8 <= $user_vote_counter :
                $level          = '<span class="va va-z-20 va-dragon"></span>';
                $level_number   = 7;
                $next_level     = false;
                break;
        }

        if($level_number != $user_level){
            $level_up = true;
            update_field('level_user', $level_number, 'user_' . $user_id);
            vkrz_push_level_up($user_id, $level);
        }

        return array(
            'user_level'        => $level_number,
            'user_level_icon'   => $level,
            'level_up'          => $level_up
        );
        
    }

    return [];
}