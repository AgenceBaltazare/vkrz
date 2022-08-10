<?php
add_action('user_register', 'new_vainkeur', 20, 1);
function new_vainkeur($user_id){

    if (isset($_COOKIE["vainkeurz_uuid_cookie"]) && !empty($_COOKIE["vainkeurz_uuid_cookie"])) {

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
                            'value' => $_COOKIE["vainkeurz_uuid_cookie"],
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

            // Update author for all "vainkeur" where uuid_user_r == vainkeurz_uuid_cookie
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
                    'value'     => $_COOKIE["vainkeurz_uuid_cookie"],
                    'compare'   => '='
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

            update_field('uuiduser_user', $_COOKIE["vainkeurz_uuid_cookie"], 'user_' . $user_id);
            update_field('id_vainkeur_user', $vainkeur_entry_result, 'user_' . $user_id);
            update_field('id_vainkeur_user', $vainkeur_entry_result, 'user_' . $user_id);
            
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
            dataLayer.push({
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