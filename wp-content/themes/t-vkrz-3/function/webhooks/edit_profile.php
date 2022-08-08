<?php

add_action( 'wppb_edit_profile_success', 'edit_profile', 20, 3 );
function edit_profile( $http_request, $form_name, $user_id ){

	// Badge : All social network fills
	$vainkeur = new WP_Query(array(
        "post_type"              => "vainkeur",
        "posts_per_page"         => "1",
        "fields"                 => "ids",
        "post_status"            => "publish",
        "ignore_sticky_posts"    => true,
        "update_post_meta_cache" => false,
        "no_found_rows"          => false,
        "author__in"             => $user_id,
    ));
    if($vainkeur->have_posts()){
        $vainkeur_id = $vainkeur->posts[0];

        if (!get_vainkeur_badge($vainkeur_id, "Connecté")) {
            if (
                get_userdata($user_id)->twitch_user ||
                get_userdata($user_id)->youtube_user ||
                get_userdata($user_id)->Instagram_user ||
                get_userdata($user_id)->tiktok_user
            ) {
                update_vainkeur_badge($vainkeur_id, "Connecté");
            }
        }
    }

}