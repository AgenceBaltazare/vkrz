<?php
include __DIR__ . '/../../../../wp-load.php';

$code = '584625846258462';


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

        if ($id_vainkeur != get_field('id_vainkeur_user', 'user_' . get_user_logged_id())){
            return $id_vainkeur;
        }
        else{
            return false;
        }
        
    }
