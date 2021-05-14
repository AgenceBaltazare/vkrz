<?php
/**
 * User_Registration_Profile_Connect setup
 *
 * @package User_Registration_Profile_Connect
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main User_Registration_Profile_Connect Class.
 *
 * @class User_Registration_Profile_Connect
 */
final class User_Registration_Profile_Connect {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.1';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin.
	 */
	private function __construct() {
		// Load plugin text domain.
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Checks if user registration is installed
		if ( defined( 'UR_VERSION' )  ) {
			$this->includes();
			add_action( 'user_registration_init', array( $this, 'plugin_updater' ) );
		} else {
			add_action( 'admin_notices', array( $this, 'user_registation_missing_notice' ) );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/user-registration-profile-connect/user-registration-profile-connect-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/user-registration-profile-connect-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'user-registration-profile-connect' );

		load_textdomain( 'user-registration-profile-connect', WP_LANG_DIR . '/user-registration-profile-connect/user-registration-profile-connect-' . $locale . '.mo' );
		load_plugin_textdomain( 'user-registration-profile-connect', false, plugin_basename( dirname( UR_PROFILE_CONNECT_PLUGIN_FILE ) ) . '/languages' );
	}

	/**
	 * Plugin Updater.
	 */
	public function plugin_updater() {
		if ( function_exists( 'ur_addon_updater' ) ) {
			/* @TODO Need to change the ID of the addon */
			ur_addon_updater( UR_PROFILE_CONNECT_PLUGIN_FILE, 2826, self::VERSION );
		}
	}

	/**
	 * Includes.
	 */
	private function includes() {
		if( is_admin() && current_user_can( 'promote_users' ) ) {
			include_once dirname( __FILE__ ) . '/class-user-registration-profile-connect-process.php';
		}
	}

	/**
	 * User Registration fallback notice.
	 */
	public function user_registation_missing_notice() {
		/* translators: %s: user-registration plugin link */
		echo '<div class="error notice is-dismissible"><p>' . sprintf( esc_html__( 'User Registration Profile Connect requires %s to work!', 'user-registration-profile-connect' ), '<a href="https://wpeverest.com/wordpress-plugins/user-registration/" target="_blank">' . esc_html__( 'User Registration', 'user-registration-profile-connect' ) . '</a>' ) . '</p></div>';
	}
}
