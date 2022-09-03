<?php if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

<<<<<<< HEAD
$bodhi_options_on_deletion = get_option('bodhi_svgs_settings');

if( $bodhi_options_on_deletion[del_plugin_data] === 'on' ) {
    delete_option( 'bodhi_svgs_plugin_version' );
    delete_option( 'bodhi_svgs_settings' );
}

?>
=======
$bodhi_options_on_deletion = get_option( 'bodhi_svgs_settings' );

if ( $bodhi_options_on_deletion[ 'del_plugin_data' ] === 'on' ) {
    delete_option( 'bodhi_svgs_plugin_version' );
    delete_option( 'bodhi_svgs_settings' );
}
>>>>>>> b4f46597bf7499598a02252b5910d378c905102f
