<?php
add_action('user_register', 'new_vainkeur', 20, 1);
function new_vainkeur($user_id){

    $new_user_infos = get_user_infos($_COOKIE["vainkeurz_user_id"]);
    $user_url       = get_author_posts_url($user_id);

    /*
    // Logguer l'erreur du user sans uuid
    if (!isset($_COOKIE['vainkeurz_user_id']) || empty($_COOKIE["vainkeurz_user_id"])){
        // TODO: Logguer une erreur avec des infos (plugin d'inscription, email, uuid, user_id, navigateur, version, os, est-ce qu'il rentre bien dans les fonctions, est-ce que les fonctions s'execute intégrallement)
    }

    $url    = "https://hook.integromat.com/q6wsg4hejd3k3mveq9nn6ycvwgc5y7kp";
    $args   = array(
        'body' => array(
            'id_vainkeur'       => $new_user_infos['id_vainkeur'],
            'user_url'          => $user_url,
            'uuid_user_vkrz'    => $new_user_infos['uuid_user_vkrz'],
            'pseudo'            => $new_user_infos['pseudo'],
            'avatar'            => $new_user_infos['avatar'],
            'user_email'        => $new_user_infos['user_email'],
            'level'             => $new_user_infos['level'],
            'level_number'      => $new_user_infos['level_number'],
            'nb_vote_vkrz'      => $new_user_infos['nb_vote_vkrz'],
            'nb_top_vkrz'       => $new_user_infos['nb_top_vkrz']
        )
    );
    wp_remote_post($url, $args);
    */


    if (isset($_COOKIE["vainkeurz_user_id"]) && !empty($_COOKIE["vainkeurz_user_id"])) {

        update_field('uuiduser_user', $_COOKIE["vainkeurz_user_id"], 'user_' . $user_id);

        if ($user_id) {
            // Update author for all "classement" where uuid_user_r == vainkeurz_user_id
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
                            'value' => $_COOKIE["vainkeurz_user_id"],
                            'compare' => '='
                        ),
                        array(
                            'key' => 'id_tournoi_r',
                            'value' => get_exclude_top(),
                            'compare' => 'NOT IN'
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

            // Update author for all "vainkeur" where uuid_user_r == vainkeurz_user_id
            $vainkeur_entry = new WP_Query(array(
                    'post_type'              => 'vainkeur',
                    'posts_per_page'         => 1,
                    'fields'                 => 'ids',
                    'post_status'            => 'publish',
                    'ignore_sticky_posts'    => true,
                    'update_post_meta_cache' => false,
                    'no_found_rows'          => false,
                    'meta_query'             => array(array(
                        'key' => 'uuid_user_vkrz',
                        'value' => $_COOKIE["vainkeurz_user_id"],
                        'compare' => '='
                    )),
                ));

            if ($vainkeur_entry->have_posts()) {
                foreach ($vainkeur_entry->posts as $vainkeur_entry_result) {
                    $arg = array(
                        'ID'            => $vainkeur_entry_result,
                        'post_author'   => $user_id,
                    );
                    wp_update_post( $arg );
                }
            }
        }
    }

    //Trigger a JS event by outputting a script in the dom above the shortcode
    ob_start();
    global $uuiduser;
    global $utm;
    $utm = deal_utm();

    ?>
    <script>
        jQuery(document).ready(function ($){
            dataLayer.push({
                event: 'track_event',
                event_name: 'signin',
                user_id : "<?= $user_id ?>",
                user_uuid : "<?= $uuiduser ?>",
                utm : "<?= $utm ?>",
                'event_score': 100
            })
        });
    </script>
    <?php
    echo ob_get_clean();

}