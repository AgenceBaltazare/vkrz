<?php
function get_vainkeur(){

    $id_vainkeur = false;
    $uuiduser    = false;

    $arr_cookie_options = array(
        'expires' => time() + 60 * 60 * 24 * 365,
        'path' => '/',
        'domain' => '',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax'
    );

    if(is_user_logged_in()){

        global $user_id;
        $user_id        = get_user_logged_id();
        $uuiduser       = get_field('uuiduser_user', 'user_'.$user_id);
        $id_vainkeur    = get_field('id_vainkeur_user', 'user_' . $user_id);

        if($uuiduser == ""){
            $uuiduser   = uniqidReal();
            update_field('uuiduser_user', $uuiduser, 'user_' . $user_id);
        }

        if ($id_vainkeur == "") {

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

            } else {

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

            update_field('id_vainkeur_user', $id_vainkeur, 'user_' . $user_id);
        }
        
    } 
    else {

        if (isset($_COOKIE["wordpress_vainkeurz_uuid_cookie"]) && $_COOKIE["wordpress_vainkeurz_uuid_cookie"] != "") {

            $uuiduser    = $_COOKIE["wordpress_vainkeurz_uuid_cookie"];

        }
        else{

            $uuiduser    = uniqidReal();

            setcookie("wordpress_vainkeurz_uuid_cookie", $uuiduser, $arr_cookie_options);

        }

        if (isset($_COOKIE["wordpress_vainkeurz_id_cookie"]) && $_COOKIE["wordpress_vainkeurz_id_cookie"] != "") {
            
            $id_vainkeur    = $_COOKIE["wordpress_vainkeurz_id_cookie"];

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
            elseif (isset($_COOKIE["wordpress_vainkeur_ready_to_be_create_cookie"]) && $_COOKIE["wordpress_vainkeur_ready_to_be_create_cookie"] != "") {

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

            setcookie("wordpress_vainkeurz_id_cookie", $id_vainkeur, $arr_cookie_options);

        }

    }

    $result         = array(
        'uuid_vainkeur'     => $uuiduser,
        'id_vainkeur'       => $id_vainkeur,
    );

    return $result;

}
