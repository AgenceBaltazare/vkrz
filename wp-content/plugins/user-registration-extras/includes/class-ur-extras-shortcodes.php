<?php
/**
 * User Registration Extras Shortcodes.
 *
 * @class    User_Registration_Extras_Shortcodes
 * @version  1.0.0
 * @package  UserRegistrationExtras/Classes
 * @category Class
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * User_Registration_Extras_Shortcodes Class
 */
class User_Registration_Extras_Shortcodes {

	public static $parts = false;

	/**
	 * Init Shortcodes.
	 */
	public static function init() {
		$shortcodes = array(
			'user_registration_popup' => __CLASS__ . '::popup',
		);

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}
	}

	/**
	 * Shortcode Wrapper.
	 *
	 * @param string[] $function
	 * @param array    $atts (default: array())
	 * @param array    $wrapper
	 *
	 * @return string
	 */
	public static function shortcode_wrapper(
		$function,
		$atts = array(),
		$wrapper = array(
			'class'  => 'user-registration-modal',
			'before' => null,
			'after'  => null,
		)
	) {
		ob_start();

		echo empty( $wrapper['before'] ) ? '<div id="user-registration-extras" class="' . esc_attr( $wrapper['class'] ) . '">' : $wrapper['before'];
		call_user_func( $function, $atts );
		echo empty( $wrapper['after'] ) ? '</div>' : $wrapper['after'];

		return ob_get_clean();
	}

	/**
	 * User Registration Extras Popup shortcode.
	 *
	 * @param mixed $atts
	 */
	public static function popup( $atts ) {

		if ( empty( $atts ) || ! isset( $atts['id'] ) ) {
			return '';
		}

		ob_start();
		self::render_popup( $atts['id'] );
		return ob_get_clean();
	}

	/**
	 * Output for popup.
	 *
	 * @since 1.0.1 Recaptcha only
	 */
	public static function render_popup( $popup_id ) {
		$post = get_post( $popup_id );

		if ( isset( $post ) && isset( $post->post_content ) ) {
			$popup_content = json_decode( $post->post_content );

			$popup_status = isset( $popup_content->popup_status ) ? $popup_content->popup_status : '';

			if ( $popup_status ) {
				$current_user_capability = apply_filters( 'ur_registration_user_capability', 'create_users' );

				if ( ( is_user_logged_in() && current_user_can( $current_user_capability ) ) || ! is_user_logged_in() ) {
					$display = 'display:block;';
					include USER_REGISTRATION_EXTRAS_TEMPLATE_PATH . '/popup-registration.php';
				}
			}
		} else {
			echo '<h2>' . esc_html__( 'Popup not found', 'user-registration-extras' ) . '</h2>';
		}
	}

}
