<?php
/**
 * MY ACCOUNT TEMPLATE MENU
 *
 * @since 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $user_registration, $wp, $post;

$logout_url = ( function_exists( 'ur_logout_url' ) ) ? ur_logout_url() : ur_get_endpoint_url( 'user-logout', '', $my_account_url );
?>


<nav class="user-registration-MyAccount-navigation">
	<ul>
		<?php
		foreach ( $endpoints as $endpoint => $options ) {
			do_action( 'urcma_print_single_endpoint', $endpoint, $options );
		}
		?>

	</ul>
</nav>
