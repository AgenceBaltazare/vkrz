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

}