<?php
/**
 * User_Registration_Field_Visibility setup
 *
 * @package User_Registration_Field_Visibility
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main User_Registration_Field_Visibility Class.
 *
 * @class User_Registration_Field_Visibility
 */
final class User_Registration_Field_Visibility {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.1.1';

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
		if ( defined( 'UR_VERSION' ) && version_compare( UR_VERSION, '1.5.8', '>=' ) ) {
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
	 *      - WP_LANG_DIR/user-registration-field-visibility/user-registration-field-visibility-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/user-registration-field-visibility-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'user-registration-field-visibility' );

		load_textdomain( 'user-registration-field-visibility', WP_LANG_DIR . '/user-registration-field-visibility/user-registration-field-visibility-' . $locale . '.mo' );
		load_plugin_textdomain( 'user-registration-field-visibility', false, plugin_basename( dirname( UR_FIELD_VISIBILITY_PLUGIN_FILE ) ) . '/languages' );
	}

	/**
	 * Plugin Updater.
	 */
	public function plugin_updater() {
		if ( function_exists( 'ur_addon_updater' ) ) {
			ur_addon_updater( UR_FIELD_VISIBILITY_PLUGIN_FILE, 18271, self::VERSION );
		}
	}

	/**
	 * Includes.
	 */
	private function includes() {
		if ( is_admin() ) {
			include_once dirname( __FILE__ ) . '/class-user-registration-field-visibility-admin.php';
		}

		include_once dirname( __FILE__ ) . '/class-user-registration-field-visibility-frontend.php';
	}

	/**
	 * User Registration fallback notice.
	 */
	public function user_registation_missing_notice() {
		/* translators: %s: user-registration plugin link */
		echo '<div class="error notice is-dismissible"><p>' . sprintf( esc_html__( 'User Registration Field Visibility requires %s version 1.6.0 or greater to work!', 'user-registration-field-visibility' ), '<a href="https://wpeverest.com/wordpress-plugins/user-registration/" target="_blank">' . esc_html__( 'User Registration', 'user-registration-field-visibility' ) . '</a>' ) . '</p></div>';
	}
}
