<?php
add_filter( 'avatar_defaults', 'new_gravatar' );
function new_gravatar ($avatar_defaults) {
    $myavatar = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
    $avatar_defaults[$myavatar] = "VAINKEURZ Avatar";
    return $avatar_defaults;
}