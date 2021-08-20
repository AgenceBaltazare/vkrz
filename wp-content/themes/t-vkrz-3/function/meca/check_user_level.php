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
                $level          = "🥚";
                $level_number   = 0;
                $next_level     = "🐣";
                break;
            case $niv_1 <= $user_vote_counter && $user_vote_counter < $niv_2 :
                $level          = "🐣";
                $level_number   = 1;
                $next_level     = "🐥";
                break;
            case $niv_2 <= $user_vote_counter && $user_vote_counter < $niv_3 :
                $level          = "🐥";
                $level_number   = 2;
                $next_level     = "🐓";
                break;
            case $niv_3 <= $user_vote_counter && $user_vote_counter < $niv_4 :
                $level          = "🐓";
                $level_number   = 3;
                $next_level     = "🦃";
                break;
            case $niv_4 <= $user_vote_counter && $user_vote_counter < $niv_5 :
                $level          = "🦃";
                $level_number   = 4;
                $next_level     = "🦢";
                break;
            case $niv_5 <= $user_vote_counter && $user_vote_counter < $niv_6 :
                $level          = "🦢";
                $level_number   = 5;
                $next_level     = "🦩";
                break;
            case $niv_6 <= $user_vote_counter && $user_vote_counter < $niv_7 :
                $level          = "🦩";
                $level_number   = 6;
                $next_level     = "🦚";
                break;
            case $niv_7 <= $user_vote_counter && $user_vote_counter < $niv_8 :
                $level          = "🦚";
                $level_number   = 7;
                $next_level     = "🐉";
                break;
            case $niv_8 <= $user_vote_counter :
                $level          = "🐉";
                $level_number   = 7;
                $next_level     = false;
                break;
        }

        if($level_number != $user_level){
            $level_up = true;
            update_field('level_user', $level_number, 'user_' . $user_id);
        }

        if($level_up == true){

            vkrz_push_levelup($user_id, $level);

        }

        return array(
            'user_level'        => $level_number,
            'user_level_icon'   => $level,
            'level_up'          => $level_up
        );
        
    }

    return [];
}