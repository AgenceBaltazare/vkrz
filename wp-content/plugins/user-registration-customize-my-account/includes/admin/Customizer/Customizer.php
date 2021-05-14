<?php
/**
 * User_Registration Customize My Account Customizer
 *
 * @package User_Registration_Customize_My_Account\Admin\Customizer
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class URCMA_Customizer.
 */
class URCMA_Customizer {

	/**
	 * Settings defaults.
	 *
	 * @var array Array of settings defaults.
	 */
	public $defaults = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function init_hooks() {
		$raw_referer = wp_parse_args( wp_parse_url( wp_get_raw_referer(), PHP_URL_QUERY ) );// phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( ( isset( $raw_referer['urcma-customizer'] ) || isset( $_GET['urcma-customizer'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification

			// Change publish button text to save.
			add_filter( 'gettext', array( $this, 'change_publish_button' ), 10, 2 );

			// Register customize panel, sections and controls.
			add_action( 'customize_register', array( $this, 'customize_register' ), 11 );

			// Remove unrelated panel, sections, components, etc.
			add_filter( 'customize_section_active', array( $this, 'section_filter' ), 10, 2 );
			add_filter( 'customize_panel_active', array( $this, 'panel_filter' ), 10, 2 );
			add_filter( 'customize_loaded_components', array( $this, 'remove_core_components' ), 10 );

			// Enqueue customizer scripts.
			add_action( 'customize_preview_init', array( $this, 'enqueue_customize_preview_scripts' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customize_control_scripts' ) );

			// Compile SASS to load on Template.
			add_action( 'customize_save_after', array( $this, 'save_after' ) );

			// Enqueue preview css in the head
			add_action( 'wp_head', array( $this, 'enqueue_css' ), 100 );
		}

	}

	/**
	 * Change publish button text to save.
	 *
	 * @param string $translation  Translated text.
	 * @param string $text         Text to translate.
	 */
	public function change_publish_button( $translation, $text ) {
		switch ( $text ) {
			case 'Publish':
				$translation = esc_html__( 'Save', 'user-registration-customize-my-account' );
				break;
			case 'Published':
				$translation = esc_html__( 'Saved', 'user-registration-customize-my-account' );
				break;
		}

		return $translation;
	}

	/**
	 * Register customize panels, sections and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public function customize_register( $wp_customize ) {
		require_once dirname( __FILE__ ) . '/Sections/Template.php';

		// Remove core partials.
		$wp_customize->selective_refresh->remove_partial( 'blogname' );
		$wp_customize->selective_refresh->remove_partial( 'blogdescription' );
		$wp_customize->selective_refresh->remove_partial( 'custom_header' );

		$this->add_panels( $wp_customize );
		$this->add_sections( $wp_customize );
		$this->add_controls( $wp_customize );
	}

	private function get_default_values() {
		if ( ! empty( $this->defaults ) ) {
			return $this->defaults;
		}
		$defaults = array();
		$controls = apply_filters( 'user_registration_customize_my_account_controls', array(), $this );

		if ( ! empty( $controls ) ) {
			foreach ( $controls as $type => $controls_data ) {
				foreach ( $controls_data as $control_key => $control_data ) {
					// Add a customize settings.
					if ( ! empty( $control_data['setting'] ) ) {
						$defaults[ $type ][ $control_key ] = $control_data['setting']['default'];
					} elseif ( ! empty( $control_data['settings'] ) ) {
						foreach ( $control_data['settings'] as $setting_key => $setting_args ) {
							$defaults[ $type ][ $setting_key ] = $setting_args['default'];
						}
					}
				}
			}
		}

		$this->defaults = $defaults;
		return $this->defaults;
	}

	/**
	 * Add panels.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public function add_panels( $wp_customize ) {

		$panels = apply_filters( 'user_registration_customize_my_account_panels', array() );

		if ( ! empty( $panels ) ) {
			foreach ( $panels as $panel_id => $panel_data ) {
				$wp_customize->add_panel(
					$panel_id,
					array(
						'title'       => isset( $panel_data['title'] ) ? $panel_data['title'] : '',
						'description' => isset( $panel_data['description'] ) ? $panel_data['description'] : '',
						'priority'    => isset( $panel_data['priority'] ) ? (int) $panel_data['priority'] : 160,
						'capability'  => isset( $panel_data['capability'] ) ? $panel_data['capability'] : 'manage_user_registration',
					)
				);
			}
		}
	}

	/**
	 * Add a customize sections.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public function add_sections( $wp_customize ) {
		$sections = apply_filters( 'user_registration_customize_my_account_sections', array() );

		if ( ! empty( $sections ) ) {
			foreach ( $sections as $section_id => $section_data ) {
				$section_args = array(
					'title'              => isset( $section_data['title'] ) ? $section_data['title'] : '',
					'description'        => isset( $section_data['description'] ) ? $section_data['description'] : '',
					'panel'              => isset( $section_data['panel'] ) ? $section_data['panel'] : '',
					'priority'           => isset( $section_data['priority'] ) ? (int) $section_data['priority'] : 160,
					'capability'         => isset( $section_data['capability'] ) ? $section_data['capability'] : 'manage_user_registration',
					'description_hidden' => isset( $section_data['description_hidden'] ) ? $section_data['description_hidden'] : false,
				);

				// Add a core or custom customize sections.
				if ( isset( $section_data['type'] ) && class_exists( $section_data['type'] ) ) {
					$wp_customize->register_section_type( $section_data['type'] );
					$wp_customize->add_section( new $section_data['type']( $wp_customize, $section_id, $section_args ) );
				} else {
					$wp_customize->add_section( $section_id, $section_args );
				}
			}
		}
	}

	/**
	 * Add a customize settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public function add_controls( $wp_customize ) {
		$controls = apply_filters( 'user_registration_customize_my_account_controls', array(), $this );

		// Include custom customize controls.
		require_once dirname( __FILE__ ) . '/Controls/ButtonSet.php';
		require_once dirname( __FILE__ ) . '/Controls/Color.php';
		require_once dirname( __FILE__ ) . '/Controls/Dimension.php';
		require_once dirname( __FILE__ ) . '/Controls/Select2.php';
		require_once dirname( __FILE__ ) . '/Controls/Slider.php';

		if ( ! empty( $controls ) ) {
			foreach ( $controls as $type => $controls_data ) {
				foreach ( $controls_data as $control_key => $control_data ) {
					$control_id = 'user_registration_customize_my_account[' . $type . '][' . $control_key . ']';
					// Control args.
					$control_args = array(
						'label'       => isset( $control_data['control']['label'] ) ? $control_data['control']['label'] : '',
						'description' => isset( $control_data['control']['description'] ) ? $control_data['control']['description'] : '',
						'section'     => isset( $control_data['control']['section'] ) ? $control_data['control']['section'] : '',
						'priority'    => isset( $control_data['control']['priority'] ) ? (int) $control_data['control']['priority'] : 160,
						'capability'  => isset( $control_data['control']['capability'] ) ? $control_data['control']['capability'] : 'manage_user_registration',
						'choices'     => isset( $control_data['control']['choices'] ) ? $control_data['control']['choices'] : array(),
						'input_attrs' => isset( $control_data['control']['input_attrs'] ) ? $control_data['control']['input_attrs'] : array(),
					);

					// Add a customize settings.
					if ( ! empty( $control_data['setting'] ) ) {
						$control_args['setting'] = $control_id;
						$this->add_customize_setting( $wp_customize, $control_id, $control_data['setting'] );
						$this->defaults[ $type ][ $control_key ] = $wp_customize->get_setting( $control_id )->default;
					} elseif ( ! empty( $control_data['settings'] ) ) {
						foreach ( $control_data['settings'] as $setting_key => $setting_args ) {
							$setting_id = 'user_registration_customize_my_account[' . $type . '][' . $setting_key . ']';
							$this->add_customize_setting( $wp_customize, $setting_id, $setting_args );
							$this->defaults[ $type ][ $setting_key ] = $wp_customize->get_setting( $setting_id )->default;
						}

						// Control settings args handling.
						if ( ! empty( $control_data['control']['settings'] ) ) {
							foreach ( $control_data['control']['settings'] as $key => $setting ) {
								$control_args['settings'][ $key ] = 'user_registration_customize_my_account[' . $type . '][' . $setting . ']';
							}
						}
					}

					// Custom control args handling.
					if ( ! empty( $control_data['control']['custom_args'] ) && is_array( $control_data['control']['custom_args'] ) ) {
						foreach ( array_keys( $control_data['control']['custom_args'] ) as $custom_arg ) {
							$control_args[ $custom_arg ] = $control_data['control']['custom_args'][ $custom_arg ];
						}
					}

					// Add a core or custom customize controls.
					if ( class_exists( $control_data['control']['type'] ) ) {
						$wp_customize->register_control_type( $control_data['control']['type'] );
						$wp_customize->add_control( new $control_data['control']['type']( $wp_customize, $control_id, $control_args ) );
					} elseif ( isset( $control_data['control']['type'] ) ) {
						$control_args['type'] = $control_data['control']['type'];
						$wp_customize->add_control( $control_id, $control_args );
					}
				}
			}
		}
	}

		/**
		 * Add a customize setting.
		 *
		 * @param WP_Customize_Manager        $wp_customize WP_Customize_Manager instance.
		 * @param WP_Customize_Setting|string $setting_id   Customize Setting object, or ID.
		 * @param array                       $setting_args {
		 *  Optional. Array of properties for the new WP_Customize_Setting. Default empty array.
		 *
		 *  @type string       $type                  Type of the setting. Default 'option'.
		 *  @type string       $capability            Capability required for the setting. Default 'manage_everest_forms'
		 *  @type string|array $theme_supports        Theme features required to support the panel. Default is none.
		 *  @type string       $default               Default value for the setting. Default is empty string.
		 *  @type string       $transport             Options for rendering the live preview of changes in Customizer.
		 *                                            Using 'refresh' makes the change visible by reloading the whole preview.
		 *                                            Using 'postMessage' allows a custom JavaScript to handle live changes.
		 * @link https://developer.wordpress.org/themes/customize-api
		 *                                            Default is 'postMessage'
		 *  @type callable     $sanitize_callback     Callback to filter a Customize setting value in un-slashed form.
		 * }
		 */
	private function add_customize_setting( $wp_customize, $setting_id, $setting_args = array() ) {
		if ( ! empty( $setting_args ) ) {
			$wp_customize->add_setting(
				$setting_id,
				array(
					'type'              => isset( $setting_args['type'] ) ? $setting_args['type'] : 'option',
					'capability'        => isset( $setting_args['capability'] ) ? $setting_args['capability'] : 'manage_user_registration',
					'theme_supports'    => isset( $setting_args['theme_supports'] ) ? $setting_args['theme_supports'] : '',
					'default'           => isset( $setting_args['default'] ) ? $setting_args['default'] : '',
					'transport'         => isset( $setting_args['transport'] ) ? $setting_args['transport'] : 'postMessage',
					'sanitize_callback' => isset( $setting_args['sanitize_callback'] ) ? $setting_args['sanitize_callback'] : '',
				)
			);
		}
	}

	/**
	 * Show only our style settings in the preview.
	 *
	 * @param bool                 $active  Whether the Customizer section is active.
	 * @param WP_Customize_Section $section WP_Customize_Section instance.
	 */
	public function section_filter( $active, $section ) {

		if ( in_array( $section->id, array( 'custom_css' ), true ) || in_array( $section->id, array_keys( apply_filters( 'user_registration_customize_my_account_sections', array() ) ), true ) ) {
			return $active;
		}

		return false;
	}

	/**
	 * Show only our style settings in the preview.
	 *
	 * @param bool               $active  Whether the Customizer panel is active.
	 * @param WP_Customize_Panel $panel WP_Customize_Section instance.
	 */
	public function panel_filter( $active, $panel ) {
		if ( in_array( $panel->id, array( 'custom_css' ), true ) || in_array( $panel->id, array_keys( apply_filters( 'user_registration_customize_my_account_panels', array() ) ), true ) ) {
			return $active;
		}

		return false;
	}

	/**
	 * Remove any unwanted core components.
	 *
	 * @param  array $components List of core components to load.
	 * @return array (Maybe) Modified components list.
	 */
	public function remove_core_components( $components ) {
		$core_components = array( 'nav_menus', 'widgets' );

		if ( ! empty( $components ) ) {
			foreach ( $components as $component_key => $component ) {
				if ( in_array( $component, $core_components, true ) ) {
					unset( $components[ $component_key ] );
				}
			}
		}

		return $components;
	}

	/**
	 * Enqueue customizer preview js.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_customize_preview_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Enqueue preview scripts .
		wp_register_script(
			'user-registration-customize-my-account-customize-preview',
			URCMA_ASSETS_URL . "/js/admin/customizer/urcma-customize-preview{$suffix}.js",
			array( 'jquery', 'customize-preview' ),
			URCMA_VERSION,
			true
		);

		// font awesome.
		wp_register_style( 'font-awesome', URCMA_ASSETS_URL . '/css/font-awesome.min.css' );
		wp_enqueue_style( 'font-awesome' );

		wp_localize_script(
			'user-registration-customize-my-account-customize-preview',
			'user_registration_customize_my_account_preview_script_data',
			array(
				'theme'   => wp_get_theme()->stylesheet,
				'notices' => array(
					'required' => esc_html__( 'This field is required.', 'user-registration-customize-my-account' ),
					'error'    => esc_html__( 'This is a sample form error message for customize puropse only.', 'user-registration-customize-my-account' ),
					'success'  => esc_html__( 'This is a sample form success message for customize puropse only.', 'user-registration-customize-my-account' ),
				),
			)
		);
		wp_enqueue_script( 'user-registration-customize-my-account-customize-preview' );
	}

	/**
	 * Enqueues the customize control scripts.
	 */
	public function enqueue_customize_control_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Enqueue controls scripts.
		wp_enqueue_style(
			'user-registration-customize-my-account-controls-style',
			URCMA_ASSETS_URL . '/css/urcma-customize-controls.css',
			array(),
			URCMA_VERSION
		);

		wp_enqueue_script(
			'user-registration-customize-my-account-controls',
			URCMA_ASSETS_URL . "/js/admin/customizer/urcma-controls{$suffix}.js",
			array( 'jquery' ),
			URCMA_VERSION,
			true
		);

		wp_localize_script(
			'user-registration-customize-my-account-controls',
			'user_registration_customize_my_account_controls_script_data',
			array(
				'panelTitle'       => esc_html__( 'User Registration &ndash; Customize My Account', 'user-registration-customize-my-account' ),
				'panelDescription' => esc_html__( 'User Registration &ndash; Customize My Account allows you to preview changes and customize My Account.', 'user-registration-customize-my-account' ),
			)
		);
	}

	/**
	 * Enqueues the preview css.
	 */
	public function enqueue_css() {
		$css = $this->compile_scss();
		printf( '<style type="text/css">%s</style>', $css );
	}

	/**
	 * Compile SCSS to CSS styles.
	 *
	 * @param int   $template_id  Template ID.
	 * @param array $defaults Template styles defaults.
	 *
	 * @return string|WP_Error The css data, or WP_Error object on failure.
	 */
	protected function compile_scss( $defaults = array() ) {
		require_once 'libraries/scssphp/scss.inc.php';

		$defaults = ! empty( $defaults ) ? $defaults : $this->get_default_values();

		ob_start();
		include 'Views/scss.php';
		$scss = ob_get_clean();

		try {
			$compiler = new ScssPhp\ScssPhp\Compiler(); // phpcs:ignore PHPCompatibility.LanguageConstructs.NewLanguageConstructs.t_ns_separatorFound
			$compiler->setFormatter( 'ScssPhp\ScssPhp\Formatter\Compressed' );
			$compiler->addImportPath( plugin_dir_path( UR_CUSTOMIZE_MY_ACCOUNT_PLUGIN_FILE ) . '/assets/css/bourbon/' );
			$compiled_css = $compiler->compile( trim( $scss ) );

			return $compiled_css;

		} catch ( Exception $e ) {
			$logger = ur_get_logger();
			$logger->warning( $e->getMessage(), array( 'source' => 'scssphp' ) );
		}

		return new WP_Error( 'could-not-compile-scss', esc_html__( 'ScssPhp: Unable to compile content', 'user-registration-customize-my-account' ) );
	}

	/**
	 * Save the styles data.
	 */
	public function save_after() {
		if ( ! isset( $_REQUEST['customized'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			return;
		}

		$save       = false;
		$customized = json_decode( wp_unslash( $_REQUEST['customized'] ), true ); // phpcs:ignore WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		// Check if valid to compile and update css.
		foreach ( array_keys( $customized ) as $setting_id ) {
			if ( false !== strpos( $setting_id, 'user_registration_customize_my_account' ) ) {
				$save = true;

				if ( false !== strpos( $setting_id, 'user_registration_customize_my_account[navigation][navigation_style]' ) ) {
					update_option( 'user_registration_my_account_layout', $customized['user_registration_customize_my_account[navigation][navigation_style]'] );
				}
				break;
			}
		}

		if ( $save ) {
			$upload_dir = wp_upload_dir();
			$custom_css = $this->compile_scss();

			$files = array(
				array(
					'base'    => $upload_dir['basedir'] . '/user_registration_customize_my_account',
					'file'    => 'index.html',
					'content' => '',
				),
				array(
					'base'    => $upload_dir['basedir'] . '/user_registration_customize_my_account',
					'file'    => 'user-registration-customize-my-account.css',
					'content' => $custom_css,
				),
			);

			// Create files and prevent hotlinking.
			foreach ( $files as $file ) {
				if ( wp_mkdir_p( $file['base'] ) && ! is_wp_error( $file['content'] ) ) {
					$file_handle = @fopen( trailingslashit( $file['base'] ) . $file['file'], 'w' ); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.file_system_read_fopen
					if ( $file_handle ) {
						fwrite( $file_handle, $file['content'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fwrite
						fclose( $file_handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
					}
				}
			}
		}
	}
}

new URCMA_Customizer();
