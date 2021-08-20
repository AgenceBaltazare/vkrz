<?php

add_action( 'wppb_edit_profile_success', 'edit_profile', 20, 3 );
function edit_profile( $http_request, $form_name, $user_id ){
	delete_transient( 'user_'.$user_id.'_deal_vainkeur_entry' );
}