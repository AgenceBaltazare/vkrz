<?php
/**
 * User_Registration Style Customizer setup
 *
 * @package User_Registration_Style_Customizer
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main User_Registration Style Customizer Class.
 *
 * @class User_Registration_Style_Customizer
 */
final class User_Registration_Style_Customizer {
	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.3';
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

		// Checks if user registration is installed.
		if ( defined( 'UR_VERSION' ) && version_compare( UR_VERSION, '1.7.0', '>=' ) ) {
			$this->configs();
			$this->includes();

			// Hooks.
			add_action( 'user_registration_init', array( $this, 'plugin_updater' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'user_registration_form_shortcode_scripts', array( $this, 'enqueue_shortcode_scripts' ) );
			add_action( 'user_registration_before_customer_login_form', array( $this, 'enqueue_login_shortcode_scripts' ) );
			add_action( 'user_registration_form_builder_wrapper_footer', array( $this, 'output_form_designer' ) );
			add_action( 'user_registration_admin_field_link', array( $this, 'render_customize_login_button' ) );
			add_filter( 'user_registration_login_options_settings', array( $this, 'login_option_customizer_button' ) );
		} else {
			add_action( 'admin_notices', array( $this, 'user_registration_missing_notice' ) );
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
	 *      - WP_LANG_DIR/user-registration-style-customizer/user-registration-style-customizer-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/user-registration-style-customizer-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'user-registration-style-customizer' );
		load_textdomain( 'user-registration-style-customizer', WP_LANG_DIR . '/user-registration-style-customizer/user-registration-style-customizer-' . $locale . '.mo' );
		load_plugin_textdomain( 'user-registration-style-customizer', false, plugin_basename( dirname( UR_STYLE_CUSTOMIZER_PLUGIN_FILE ) ) . '/languages' );
	}
	/**
	 * Configs.
	 */
	private function configs() {

		if ( ! isset( $_GET['ur-customize-login'] ) ) {
			require_once dirname( __FILE__ ) . '/configs/registration/ur-style-customizer-templates-configs.php';
			require_once dirname( __FILE__ ) . '/configs/registration/ur-style-customizer-form-wrapper-configs.php';
			require_once dirname( __FILE__ ) . '/configs/registration/ur-style-customizer-field-label-configs.php';
			require_once dirname( __FILE__ ) . '/configs/registration/ur-style-customizer-field-description-configs.php';
			require_once dirname( __FILE__ ) . '/configs/registration/ur-style-customizer-field-styles-configs.php';
			require_once dirname( __FILE__ ) . '/configs/registration/ur-style-customizer-radio-checkbox-styles-configs.php';
			require_once dirname( __FILE__ ) . '/configs/registration/ur-style-customizer-section-title-configs.php';
			require_once dirname( __FILE__ ) . '/configs/registration/ur-style-customizer-button-configs.php';
			require_once dirname( __FILE__ ) . '/configs/registration/ur-style-customizer-messages-configs.php';
		} else {
			require_once dirname( __FILE__ ) . '/configs/login/ur-style-customizer-templates-configs.php';
			require_once dirname( __FILE__ ) . '/configs/login/ur-style-customizer-form-wrapper-configs.php';
			require_once dirname( __FILE__ ) . '/configs/login/ur-style-customizer-field-label-configs.php';
			require_once dirname( __FILE__ ) . '/configs/login/ur-style-customizer-field-styles-configs.php';
			require_once dirname( __FILE__ ) . '/configs/login/ur-style-customizer-checkbox-styles-configs.php';
			require_once dirname( __FILE__ ) . '/configs/login/ur-style-customizer-button-configs.php';
			require_once dirname( __FILE__ ) . '/configs/login/ur-style-customizer-messages-configs.php';
		}
	}
	/**
	 * Includes.
	 */
	private function includes() {
		require_once dirname( __FILE__ ) . '/class-ur-style-customizer-api.php';
	}
	/**
	 * Get the customizer url.
	 */
	private function get_customizer_url() {
		$form_id        = isset( $_GET['edit-registration'] ) ? absint( $_GET['edit-registration'] ) : false; // WPCS: input var ok, CSRF ok.
		$customizer_url = esc_url_raw(
			add_query_arg(
				array(
					'ur-style-customizer' => true,
					'form_id'             => $form_id,
					'return'              => rawurlencode(
						add_query_arg(
							array(
								'page'              => 'add-new-registration',
								'edit-registration' => $form_id,
							),
							admin_url( 'admin.php' )
						)
					),
				),
				admin_url( 'customize.php' )
			)
		);
		return $customizer_url;
	}

	/**
	 * Get the login customizer url.
	 */
	private function get_login_customizer_url() {
		$customizer_url = esc_url_raw(
			add_query_arg(
				array(
					'ur-style-customizer' => true,
					'ur-customize-login'  => true,
					'return'              => rawurlencode(
						add_query_arg(
							array(
								'page'    => 'user-registration-settings',
								'tab'     => 'general',
								'section' => 'login-options',
							),
							admin_url( 'admin.php' )
						)
					),
				),
				admin_url( 'customize.php' )
			)
		);
		return $customizer_url;
	}

	/**
	 * Plugin Updater.
	 */
	public function plugin_updater() {
		if ( function_exists( 'ur_addon_updater' ) ) {
			ur_addon_updater( UR_STYLE_CUSTOMIZER_PLUGIN_FILE, 26043, self::VERSION );
		}
	}

	/**
	 * Enqueue scripts.
	 */
	public function admin_enqueue_scripts() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';
		// Register admin scripts.
		wp_register_style( 'user-registration-customize-admin', plugins_url( '/assets/css/customize-admin.css', UR_STYLE_CUSTOMIZER_PLUGIN_FILE ), array(), self::VERSION );
		// Add RTL support for admin styles.
		wp_style_add_data( 'user-registration-customize-admin', 'rtl', 'replace' );
		// Admin styles for UR Admin pages only.
		if ( in_array( $screen_id, ur_get_screen_ids(), true ) ) {
			wp_enqueue_style( 'user-registration-customize-admin' );
		}
	}

	/**
	 * Enqueue shortcode scripts.
	 *
	 * @param array $atts Shortcode Attributes.
	 */
	public function enqueue_shortcode_scripts( $atts ) {

		$form_id       = absint( $atts['id'] );
		$upload_dir    = wp_upload_dir( null, false );
		$style_options = get_option( 'user_registration_styles' );

		// Enqueue shortcode styles.
		if ( file_exists( trailingslashit( $upload_dir['basedir'] ) . 'user_registration_styles/user-registration-' . $form_id . '.css' ) ) {
			wp_enqueue_style( 'user-registration-style-' . $form_id, trailingslashit( $upload_dir['baseurl'] ) . 'user_registration_styles/user-registration-' . $form_id . '.css', array(), filemtime( trailingslashit( $upload_dir['basedir'] ) . 'user_registration_styles/user-registration-' . $form_id . '.css' ), 'all' );
		}

		// Enqueue google fonts styles.
		if ( isset( $style_options[ $form_id ]['wrapper']['font_family'] ) && '' !== $style_options[ $form_id ]['wrapper']['font_family'] ) {
			wp_enqueue_style( 'user-registration-google-fonts', 'https://fonts.googleapis.com/css?family=' . ur_clean( $style_options[ $form_id ]['wrapper']['font_family'] ), array(), self::VERSION, 'all' );
		}
	}

	/**
	 * Enqueue login shortcode scripts.
	 */
	public function enqueue_login_shortcode_scripts() {

		$upload_dir    = wp_upload_dir( null, false );
		$style_options = get_option( 'user_registration_login_styles' );

		// Enqueue shortcode styles.
		if ( file_exists( trailingslashit( $upload_dir['basedir'] ) . 'user_registration_styles/user-registration-login.css' ) ) {
			wp_enqueue_style( 'user-registration-style-login', trailingslashit( $upload_dir['baseurl'] ) . 'user_registration_styles/user-registration-login.css', array(), filemtime( trailingslashit( $upload_dir['basedir'] ) . 'user_registration_styles/user-registration-login.css' ), 'all' );
		}

		// Enqueue google fonts styles.
		if ( isset( $style_options['wrapper']['font_family'] ) && '' !== $style_options['wrapper']['font_family'] ) {
			wp_enqueue_style( 'user-registration-google-fonts', 'https://fonts.googleapis.com/css?family=' . ur_clean( $style_options['wrapper']['font_family'] ), array(), self::VERSION, 'all' );
		}
	}

	/**
	 * Output form designer.
	 */
	public function output_form_designer() {
		?>
		<a href="<?php echo esc_url( $this->get_customizer_url() ); ?>" class="button button-primary button-icon button-icon-round button-style-customizer" title="<?php esc_attr_e( 'Form Designer', 'user-registration-style-customizer' ); ?>">
			<span class="dashicons dashicons-admin-appearance"></span>
		</a>
		<?php
	}

	/**
	 * Render Login customize button.
	 *
	 * @param array $value Setting value.
	 */
	public function render_customize_login_button( $value ) {
		$field_description = UR_Admin_Settings::get_field_description( $value );
		?>
		<tr valign="top" class="<?php echo esc_attr( $value['row_class'] ); ?>">
			<th scope="row" class="titledesc">
				<label><?php echo esc_attr( $value['title'] ); ?></label>
				<?php echo $field_description['tooltip_html']; ?>
			</th>
			<td>
				<?php
				if ( isset( $value['buttons'] ) && is_array( $value['buttons'] ) ) {
					foreach ( $value['buttons'] as $button ) {
						?>
						<a
							href="<?php echo esc_url( $button['href'] ); ?>"
							class="button <?php echo esc_attr( $button['class'] ); ?>">
							<?php echo esc_html( $button['title'] ); ?>
						</a>
						<?php
					}
				}
				?>
				<?php echo ( isset( $value['desc'] ) && isset( $value['desc_tip'] ) && true !== $value['desc_tip'] ) ? '<p class="description" >' . esc_html( $value['desc'] ) . '</p>' : ''; ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Setting option for login customizer button.
	 *
	 * @param array $settings Settings.
	 */
	public function login_option_customizer_button( $settings ) {

		$first_slice = array_slice( $settings, 0, count( $settings ) - 1 );
		$last_slice  = array_slice( $settings, count( $settings ) - 1 );
		$settings    = array_merge(
			$first_slice,
			array(
				array(
					'title'    => __( 'Customize Login Form', 'user-registration-style-customizer' ),
					'desc'     => __( 'Make the login form more elegant and unique. Customize the design styles for form wrapper, fields, texts, button and more.', 'user-registration-style-customizer' ),
					'desc_tip' => __( 'Customize the design style for login form.', 'user-registration-style-customizer' ),
					'type'     => 'link',
					'buttons'  => array(
						array(
							'title' => __( 'Customize Login Form', 'user-registration-style-customizer' ),
							'href'  => $this->get_login_customizer_url(),
							'class' => 'button-customize-login',
						),
					),
				),
			),
			$last_slice
		);
		return $settings;
	}
	/**
	 * User Registration fallback notice.
	 */
	public function user_registration_missing_notice() {
		/* translators: %s: user-registration plugin link */
		echo '<div class="error notice is-dismissible"><p>' . sprintf( esc_html__( 'User Registration Style Customizer requires %s version 1.7.0 or greater to work!', 'user-registration-style-customizer' ), '<a href="https://wpeverest.com/wordpress-plugins/user-registration/" target="_blank">' . esc_html__( 'User Registration', 'user-registration-style-customizer' ) . '</a>' ) . '</p></div>';
	}

	/**
	 * Deprecates old plugin missing notice.
	 *
	 * @deprecated 1.0.2
	 *
	 * @return void
	 */
	public function user_registation_missing_notice() {
		ur_deprecated_function( 'User_Registration_Style_Customizer::user_registation_missing_notice', '1.0.2', 'User_Registration_Style_Customizer::user_registration_missing_notice' );
	}
}
