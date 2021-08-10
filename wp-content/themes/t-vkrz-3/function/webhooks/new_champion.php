<?php
add_action('user_register', 'new_champion', 10, 1);
function new_champion($user_id){

    $user_data      = get_user_by('ID', $user_id);
    $user_name      = $user_data->nickname;
    if(get_avatar_url($user_id, ['size' => '80'])){
        $user_avatar = get_avatar_url($user_id, ['size' => '80']);
    }
    else{
        $user_avatar = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
    }
    $user_url       = get_author_posts_url($user_id);

    $url    = "https://hook.integromat.com/uiuymy9i8o09fztl10pkjctqqlwg264w";
    $args   = array(
        'body' => array(
            'user_name'    => $user_name,
            'user_avatar'  => $user_avatar,
            'user_url'     => $user_url
        )
    );

    wp_remote_post($url, $args);

    // Update author for all "classement" where uuid_user_r == vainkeurz_user_id
    if (isset($_COOKIE["vainkeurz_user_id"])) {
        $classements = new WP_Query(array(
                'post_type'              => 'classement',
                'posts_per_page'         => -1,
                'fields'                 => 'ids',
                'post_status'            => 'publish',
                'ignore_sticky_posts'    => true,
                'update_post_meta_cache' => false,
                'no_found_rows'          => false,
                'author__not_in'         => array($user_id),
                'meta_query'             => array(array(
                                               'key' => 'uuid_user_r',
                                               'value' => $_COOKIE["vainkeurz_user_id"],
                                               'compare' => '='
                                           )),
            ));

        if ($classements->have_posts()) {
            foreach ($classements->posts as $classement) {
                $arg = array(
                    'ID' => $classement,
                    'post_author' => $user_id,
                );
                wp_update_post( $arg );
            }
        }
    }

}