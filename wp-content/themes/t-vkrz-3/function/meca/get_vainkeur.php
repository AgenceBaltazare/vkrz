<?php
function get_vainkeur(){

    $id_vainkeur = false;
    $uuiuser     = false;
    
    if(is_user_logged_in()){

        global $user_id;
        $user_id        = get_user_logged_id();
        $uuiuser        = get_field('uuiduser_user', 'user_'.$user_id);
        $id_vainkeur    = get_field('id_vainkeur_user', 'user_' . $user_id);
        
    } 
    else {

        if (isset($_COOKIE["vainkeurz_uuid_cookie"]) && $_COOKIE["vainkeurz_uuid_cookie"] != "") {

            $uuiduser    = $_COOKIE["vainkeurz_uuid_cookie"];
        }
        else{

            $uuiduser    = uniqidReal();

            if (!isset($_COOKIE['vainkeurz_uuid_cookie']) || empty($_COOKIE["vainkeurz_uuid_cookie"])) {
                setcookie("vainkeurz_uuid_cookie", $uuiduser, time() + 31556926, "/");
            }

        }

        if (isset($_COOKIE["vainkeurz_id_cookie"]) && $_COOKIE["vainkeurz_id_cookie"] != "") {
            
            $id_vainkeur    = $_COOKIE["vainkeurz_id_cookie"];

        } 
        else {

            $vainkeur_entry = new WP_Query(array(
                'post_type'              => 'vainkeur',
                'posts_per_page'         => '1',
                'fields'                 => 'ids',
                'post_status'            => 'publish',
                'ignore_sticky_posts'    => true,
                'update_post_meta_cache' => false,
                'no_found_rows'          => false,
                'meta_query'             => array(
                    array(
                        'key'       => 'uuid_user_vkrz',
                        'value'     => $uuiduser,
                        'compare'   => '='
                    )
                )
            ));

            if ($vainkeur_entry->have_posts()) {

                $id_vainkeur    = $vainkeur_entry->posts[0];
                
            } 
            elseif (isset($_COOKIE["vainkeur_ready_to_be_create_cookie"]) && $_COOKIE["vainkeur_ready_to_be_create_cookie"] != "") {

                $new_vainkeur_entry = array(
                    'post_type'   => 'vainkeur',
                    'post_title'  => $uuiduser,
                    'post_status' => 'publish',
                );

                if ($uuiduser) {
                    $id_vainkeur  = wp_insert_post($new_vainkeur_entry);

                    update_field('uuid_user_vkrz', $uuiduser, $id_vainkeur);
                    update_field('nb_vote_vkrz', 0, $id_vainkeur);
                    update_field('nb_top_vkrz', 0, $id_vainkeur);

                    // Save vainkeur to firebase
                    wp_update_post(array('ID' => $id_vainkeur));
                }
            }
        }

    }

    $result         = array(
        'uuid_vainkeur'     => $uuiuser,
        'id_vainkeur'       => $id_vainkeur,
    );

    return $result;

}
