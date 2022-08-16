<?php

function pmui_pmxi_before_post_import( $import_id ) {
	$import = new PMXI_Import_Record();
	$import->getById( $import_id );
	if ( ! $import->isEmpty() and ( $import->options['custom_type'] == 'import_users' or $import->options['custom_type'] == 'shop_customer' ) and ! empty($import->options['do_not_send_password_notification'])) {
		remove_all_actions( 'um_registration_complete' );
		add_filter('send_password_change_email', 'pmui_do_not_send_password_notification', 99, 3);
		add_filter('send_email_change_email', 'pmui_send_email_change_email', 99, 3);
	}
}