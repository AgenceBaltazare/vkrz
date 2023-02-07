<?php
add_action('user_register', 'new_vainkeur', 20, 1);
function new_vainkeur($user_id){

    if (isset($_COOKIE["wordpress_vainkeurz_uuid_cookie"]) && !empty($_COOKIE["wordpress_vainkeurz_uuid_cookie"])) {

        $uuid_vainkeur = $_COOKIE["wordpress_vainkeurz_uuid_cookie"];

        if ($user_id) {
            $classements = new WP_Query(array(
                    'post_type'              => 'classement',
                    'posts_per_page'         => -1,
                    'fields'                 => 'ids',
                    'post_status'            => 'publish',
                    'ignore_sticky_posts'    => true,
                    'update_post_meta_cache' => false,
                    'no_found_rows'          => false,
                    'author__not_in'         => array($user_id),
                    'meta_query'             => array(
                        array(
                            'key' => 'uuid_user_r',
                            'value' => $uuid_vainkeur,
                            'compare' => '='
                        )
                    )
                ));

            if ($classements->have_posts()) {
                foreach ($classements->posts as $classement) {
                    $arg = array(
                        'ID'            => $classement,
                        'post_author'   => $user_id,
                    );
                    wp_update_post( $arg );
                }
            }

            // Update author for all "vainkeur" where uuid_user_r == wordpress_vainkeurz_uuid_cookie
            $vainkeur_entry = new WP_Query(array(
                'post_type'              => 'vainkeur',
                'posts_per_page'         => 1,
                'fields'                 => 'ids',
                'post_status'            => 'publish',
                'ignore_sticky_posts'    => true,
                'update_post_meta_cache' => false,
                'no_found_rows'          => false,
                'meta_query'             => array(array(
                    'key'       => 'uuid_user_vkrz',
                    'value'     => $uuid_vainkeur,
                    'compare'   => '='
                )),
            ));

            if ($vainkeur_entry->have_posts()) {
                foreach ($vainkeur_entry->posts as $id_vainkeur) {
                    $arg = array(
                        'ID'            => $id_vainkeur,
                        'post_author'   => $user_id,
                    );
                    wp_update_post( $arg );
                }
            }
            else{

                $new_vainkeur_entry = array(
                    'post_type'   => 'vainkeur',
                    'post_title'  => $uuid_vainkeur,
                    'post_status' => 'publish',
                    'post_author' => $user_id
                );

                if ($uuid_vainkeur) {

                    $id_vainkeur  = wp_insert_post($new_vainkeur_entry);

                    update_field('uuid_user_vkrz', $uuid_vainkeur, $id_vainkeur);
                    update_field('nb_vote_vkrz', 0, $id_vainkeur);
                    update_field('nb_top_vkrz', 0, $id_vainkeur);

                    // Save vainkeur to firebase
                    wp_update_post(array('ID' => $id_vainkeur));

                    $arr_cookie_options = array(
                        'expires' => time() + 60 * 60 * 24 * 365,
                        'path' => '/',
                        'domain' => '',
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'Lax'
                    );
                    setcookie("wordpress_vainkeurz_id_cookie", $id_vainkeur, $arr_cookie_options);
                }

            }

            update_field('uuiduser_user', $uuid_vainkeur, 'user_' . $user_id);
            update_field('id_vainkeur_user', $id_vainkeur, 'user_' . $user_id);

            // Set uniq code for parrainage
            $uniqcodeparrain = generate_codeparrain($user_id);
            update_field('code_parrain_user', $uniqcodeparrain, 'user_' . $user_id);

            // DEAL REFERRAL CODE IF HE USED ONE
            if($_GET['codeinvit']) {
                deal_referral($_GET['codeinvit'], $id_vainkeur, 200);
            }

            // SEND/UPDATE USER TO FIREBASE
            $user_infos  = get_user_infos($uuid_vainkeur);

            $utilisateur                   = new stdClass();
            $utilisateur->Pseudo           = $user_infos['pseudo'];
            $utilisateur->Image            = $user_infos['avatar'];
            $utilisateur->Email            = $user_infos['user_email'];
            $utilisateur->UUID             = $user_infos['uuid_vainkeur'];
            $utilisateur->idVainkeur       = $user_infos['id_vainkeur'];
            $utilisateur->level            = $user_infos['level_number'];
            $utilisateur->role             = $user_infos['user_role'];
            $utilisateur->Twitch           = get_userdata($user_id)->twitch_user;
            $utilisateur->YouTube          = get_userdata($user_id)->youtube_user;
            $utilisateur->Instagram        = get_userdata($user_id)->Instagram_user;
            $utilisateur->TikTok           = get_userdata($user_id)->tiktok_user;
            $utilisateur->Twitter          = get_userdata($user_id)->twitter_user;
            $utilisateur->RegistrationDate = date("d-m-Y H:i:s", strtotime(get_userdata( $user_id )->user_registered));
            
            apply_filters('firebase_save_data_to_database', "firestore", "utilizateurs", get_userdata($user_id)->user_login, $utilisateur);
        }
    }

    //Trigger a JS event by outputting a script in the dom above the shortcode
    ob_start();
    global $uuid_vainkeur;
    global $utm;
    $utm = deal_utm();

    ?>
    <script>
        jQuery(document).ready(function ($){
            window.dataLayer.push({
                event: 'track_event',
                event_name: 'signin',
                user_id : "<?= $user_id ?>",
                user_uuid : "<?= $uuid_vainkeur ?>",
                utm : "<?= $utm ?>",
                'event_score': 100
            })
        });
    </script>
    <?php
    echo ob_get_clean();
}

// SEND/UPDATE USER TO FIREBASE
add_action( 'set_user_role', function( $user_id ) 
{
    
    add_action( 'profile_update', function( $user_id )
    {
        $uuid_vainkeur = get_field('uuiduser_user', 'user_' . $user_id);

        $user_infos    = get_user_infos($uuid_vainkeur);

        $utilisateur                   = new stdClass();
        $utilisateur->role             = $user_infos['user_role'];

        apply_filters('firebase_save_data_to_database', "firestore", "utilizateurs", get_userdata($user_id)->user_login, $utilisateur);
    } );

} );
