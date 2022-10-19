<?php
function generate_codeparrain($user_id){

    $random     = rand(10, 999);
    $uniquecode = $user_id . $random;

    return $uniquecode;

}

function check_codeparrain($code)
{

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

        if($id_vainkeur){
            return $id_vainkeur;
        }
        else{
            return 'Aucun parrain trouvé';
        }

    }

}