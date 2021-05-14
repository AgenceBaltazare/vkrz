<?php
/**
 * User_Registration Style Customizer
 *
 * @package User_Registration_Style_Customizer\API
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Style Customizer API.
 */
class UR_Style_Customizer_API {

	/**
	 * Form ID.
	 *
	 * @var int
	 */
	public $form_id;

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
		$raw_referer     = wp_parse_args( wp_parse_url( wp_get_raw_referer(), PHP_URL_QUERY ) );
		$this->form_id   = isset( $_GET['form_id'] ) ? absint( $_GET['form_id'] ) : false; // WPCS: input var ok, CSRF ok.
		$customize_login = isset( $_GET['ur-customize-login'] ) ? $_GET['ur-customize-login'] : false;

		if ( wp_get_raw_referer() ) {
			$this->form_id   = isset( $raw_referer['form_id'] ) ? absint( $raw_referer['form_id'] ) : $this->form_id;
			$customize_login = isset( $raw_referer['ur-customize-login'] ) ? $raw_referer['ur-customize-login'] : $customize_login;
		}

		// Load customizer elements for EVF forms only.
		if ( ( isset( $raw_referer['ur-style-customizer'] ) || isset( $_GET['ur-style-customizer'] ) ) ) { // WPCS: CSRF ok.

			// Change publish button text to save.
			add_filter( 'gettext', array( $this, 'change_publish_button' ), 10, 2 );

			if ( $this->form_id ) {

				// Register customize panel, sections and controls.
				add_action( 'customize_register', array( $this, 'registration_customize_register' ), 11 );

				// Customize form preview URL.
				add_action( 'customize_controls_init', array( $this, 'registration_form_preview_init' ) );

				// Compile SASS to load on frontend.
				add_action( 'customize_save_after', array( $this, 'registration_save_after' ) );
			} elseif ( $customize_login ) {

				// Register customize panel, sections and controls.
				add_action( 'customize_register', array( $this, 'login_customize_register' ), 11 );

				// Customize form preview URL.
				add_action( 'customize_controls_init', array( $this, 'login_form_preview_init' ) );

				// Compile SASS to load on frontend.
				add_action( 'customize_save_after', array( $this, 'login_save_after' ) );
			}

			// Remove unrelated panel, sections, components, etc.
			add_filter( 'customize_section_active', array( $this, 'section_filter' ), 10, 2 );
			add_filter( 'customize_loaded_components', array( $this, 'remove_core_components' ), 60 );

			// Enqueue customizer scripts.
			add_action( 'customize_preview_init', array( $this, 'enqueue_customize_preview_scripts' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customize_control_scripts' ) );
		}

		// Delete specific styles on form delete.
		add_action( 'deleted_post', array( $this, 'delete_styles' ) );
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
				$translation = __( 'Save', 'user-registration-style-customizer' );
				break;
			case 'Published':
				$translation = __( 'Saved', 'user-registration-style-customizer' );
				break;
		}

		return $translation;
	}

	/**
	 * Show only our style settings in the preview.
	 *
	 * @param bool                 $active  Whether the Customizer section is active.
	 * @param WP_Customize_Section $section WP_Customize_Section instance.
	 */
	public function section_filter( $active, $section ) {
		if ( in_array( $section->id, array( 'custom_css' ), true ) || in_array( $section->id, array_keys( apply_filters( 'user_registration_style_customizer_sections', array() ) ), true ) ) {
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
	 * Callback for validating a background setting value.
	 *
	 * @since  1.0.0
	 *
	 * @param  string               $value Repeat value.
	 * @param  WP_Customize_Setting $setting Setting.
	 * @return string|WP_Error Background value or validation error.
	 */
	public function sanitize_background_setting( $value, $setting ) {
		if ( 'user_registration_styles[' . $this->form_id . '][wrapper][background_repeat]' === $setting->id ) {
			if ( ! in_array( $value, array( 'repeat-x', 'repeat-y', 'repeat', 'no-repeat' ), true ) ) {
				return new WP_Error( 'invalid_value', __( 'Invalid value for background repeat.', 'user-registration-style-customizer' ) );
			}
		} elseif ( 'user_registration_styles[' . $this->form_id . '][wrapper][background_attachment]' === $setting->id ) {
			if ( ! in_array( $value, array( 'fixed', 'scroll' ), true ) ) {
				return new WP_Error( 'invalid_value', __( 'Invalid value for background attachment.', 'user-registration-style-customizer' ) );
			}
		} elseif ( 'user_registration_styles[' . $this->form_id . '][wrapper][background_position_x]' === $setting->id ) {
			if ( ! in_array( $value, array( 'left', 'center', 'right' ), true ) ) {
				return new WP_Error( 'invalid_value', __( 'Invalid value for background position X.', 'user-registration-style-customizer' ) );
			}
		} elseif ( 'user_registration_styles[' . $this->form_id . '][wrapper][background_position_y]' === $setting->id ) {
			if ( ! in_array( $value, array( 'top', 'center', 'bottom' ), true ) ) {
				return new WP_Error( 'invalid_value', __( 'Invalid value for background position Y.', 'user-registration-style-customizer' ) );
			}
		} elseif ( 'user_registration_styles[' . $this->form_id . '][wrapper][background_size]' === $setting->id ) {
			if ( ! in_array( $value, array( 'auto', 'contain', 'cover' ), true ) ) {
				return new WP_Error( 'invalid_value', __( 'Invalid value for background size.', 'user-registration-style-customizer' ) );
			}
		} elseif ( 'user_registration_styles[' . $this->form_id . '][wrapper][background_preset]' === $setting->id ) {
			if ( ! in_array( $value, array( 'default', 'fill', 'fit', 'repeat', 'custom' ), true ) ) {
				return new WP_Error( 'invalid_value', __( 'Invalid value for background size.', 'user-registration-style-customizer' ) );
			}
		} elseif ( 'user_registration_styles[' . $this->form_id . '][wrapper][background_image]' === $setting->id ) {
			$value = empty( $value ) ? '' : esc_url_raw( $value );
		} else {
			return new WP_Error( 'unrecognized_setting', __( 'Unrecognized background setting.', 'user-registration-style-customizer' ) );
		}
		return $value;
	}

	/**
	 * Preview form in customizer.
	 */
	public function registration_form_preview_init() {
		global $wp_customize;

		if ( isset( $_GET['form_id'] ) ) { // WPCS: CSRF ok.
			$form_id = absint( $_GET['form_id'] );
			$wp_customize->set_preview_url(
				add_query_arg(
					array(
						'form_id'             => $form_id,
						'ur_preview'          => true,
						'ur-style-customizer' => true,
					),
					$wp_customize->get_preview_url()
				)
			);
		}
	}

	/**
	 * Preview form in customizer.
	 */
	public function login_form_preview_init() {
		global $wp_customize;

		if ( isset( $_GET['ur-customize-login'] ) ) { // WPCS: CSRF ok.
			$wp_customize->set_preview_url(
				add_query_arg(
					array(
						'ur-customize-login'  => true,
						'ur_login_preview'    => true,
						'ur-style-customizer' => true,
					),
					$wp_customize->get_preview_url()
				)
			);
		}
	}

	/**
	 * Enqueues the customize preview scripts.
	 */
	public function enqueue_customize_preview_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Enqueue preview scripts.
		wp_enqueue_script( 'user-registration-customize-preview', plugins_url( "/assets/js/admin/customize-preview{$suffix}.js", UR_STYLE_CUSTOMIZER_PLUGIN_FILE ), array( 'jquery', 'customize-preview' ), User_Registration_Style_Customizer::VERSION, true );
		wp_localize_script(
			'user-registration-customize-preview',
			'_urCustomizePreviewL10n',
			array(
				'form_id'   => $this->form_id,
				'templates' => $this->get_template_choices(),
			)
		);
	}

	/**
	 * Enqueues the customize control scripts.
	 */
	public function enqueue_customize_control_scripts() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Register control scripts.
		wp_register_style( 'selectWoo', plugins_url( '/assets/css/select2.css', UR_PLUGIN_FILE ), array(), UR_VERSION );
		wp_register_script( 'selectWoo', plugins_url( "/assets/js/selectWoo/selectWoo.full{$suffix}.js", UR_PLUGIN_FILE ), array( 'jquery' ), '1.0.4', true );

		// Enqueue controls scripts.
		wp_enqueue_style( 'user-registration-customize-controls', plugins_url( '/assets/css/customize-controls.css', UR_STYLE_CUSTOMIZER_PLUGIN_FILE ), array(), User_Registration_Style_Customizer::VERSION );
		wp_enqueue_script( 'user-registration-customize-controls', plugins_url( "/assets/js/admin/customize-controls{$suffix}.js", UR_STYLE_CUSTOMIZER_PLUGIN_FILE ), array( 'jquery' ), User_Registration_Style_Customizer::VERSION, true );
		wp_localize_script(
			'user-registration-customize-controls',
			'_urCustomizeControlsL10n',
			array(
				'form_id'          => $this->form_id,
				'panelTitle'       => esc_html( 'User Registration &ndash; Styles', 'user-registration-style-customizer' ),
				'panelDescription' => esc_html( 'User Registration &ndash; Styles Customizer allows you to preview changes and customize any form elements.', 'user-registration-style-customizer' ),
			)
		);
	}

	/**
	 * Register customize panels, sections and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public function registration_customize_register( $wp_customize ) {

		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-templates-section.php';

		// Remove core partials.
		$wp_customize->selective_refresh->remove_partial( 'blogname' );
		$wp_customize->selective_refresh->remove_partial( 'blogdescription' );
		$wp_customize->selective_refresh->remove_partial( 'custom_header' );

		$this->add_customize_panels( $wp_customize );
		$this->add_customize_sections( $wp_customize );
		$this->add_customize_controls( $wp_customize );

		$template_id = 'user_registration_styles[' . $this->form_id . '][template]';

		// Include customize control until we fetch via AJAX.
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-image-radio-control.php';

		$wp_customize->add_setting(
			$template_id,
			array(
				'default'           => 'default',
				'transport'         => 'postMessage',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'manage_user_registration',
			)
		);

		$this->defaults['template'] = $wp_customize->get_setting( $template_id )->default;

		$wp_customize->add_control(
			new UR_Customize_Image_Radio_Control(
				$wp_customize,
				$template_id,
				array(
					'label'         => __( 'Templates', 'user-registration-style-customizer' ),
					'description'   => __( 'Choose your desire templates.', 'user-registration-style-customizer' ),
					'section'       => 'user_registration_templates',
					'capability'    => 'manage_user_registration',
					'setting'       => $template_id,
					'priority'      => 0,
					'display_label' => true,
					'choices'       => $this->get_template_choices(),
					'input_attrs'   => $this->get_templates_data(),
				)
			)
		);
	}

	/**
	 * Register customize panels, sections and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public function login_customize_register( $wp_customize ) {

		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-templates-section.php';

		// Remove core partials.
		$wp_customize->selective_refresh->remove_partial( 'blogname' );
		$wp_customize->selective_refresh->remove_partial( 'blogdescription' );
		$wp_customize->selective_refresh->remove_partial( 'custom_header' );

		$this->add_customize_panels( $wp_customize );
		$this->add_customize_sections( $wp_customize );
		$this->add_login_customize_controls( $wp_customize );

		$template_id = 'user_registration_login_styles[template]';

		// Include customize control until we fetch via AJAX.
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-image-radio-control.php';

		$wp_customize->add_setting(
			$template_id,
			array(
				'default'           => 'default',
				'transport'         => 'postMessage',
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'manage_user_registration',
			)
		);

		$this->defaults['template'] = $wp_customize->get_setting( $template_id )->default;

		$wp_customize->add_control(
			new UR_Customize_Image_Radio_Control(
				$wp_customize,
				$template_id,
				array(
					'label'         => __( 'Templates', 'user-registration-style-customizer' ),
					'description'   => __( 'Choose your desire templates.', 'user-registration-style-customizer' ),
					'section'       => 'user_registration_templates',
					'capability'    => 'manage_user_registration',
					'setting'       => $template_id,
					'priority'      => 0,
					'display_label' => true,
					'choices'       => $this->get_login_template_choices(),
					'input_attrs'   => $this->get_login_templates_data(),
				)
			)
		);
	}

	/**
	 * Add customize panels.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public function add_customize_panels( $wp_customize ) {

		$panels = apply_filters( 'user_registration_style_customizer_panels', array() );
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
	 * Add customize sections.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public function add_customize_sections( $wp_customize ) {

		$sections = apply_filters( 'user_registration_style_customizer_sections', array() );

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
	 * Add customize settings.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	private function add_customize_settings( $wp_customize, $setting_id, $setting_args ) {

		if ( ! empty( $setting_args ) ) {
			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => isset( $setting_args['default'] ) ? $setting_args['default'] : '',
					'transport'         => isset( $setting_args['transport'] ) ? $setting_args['transport'] : 'postMessage',
					'type'              => isset( $setting_args['type'] ) ? $setting_args['type'] : 'option',
					'theme_supports'    => isset( $setting_args['theme_supports'] ) ? $setting_args['theme_supports'] : '',
					'sanitize_callback' => isset( $setting_args['sanitize_callback'] ) ? $setting_args['sanitize_callback'] : '',
					'capability'        => isset( $setting_args['capability'] ) ? $setting_args['capability'] : 'manage_user_registration',
				)
			);
		}
	}

	/**
	 * Add customize settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public function add_customize_controls( $wp_customize ) {

		$controls = apply_filters( 'user_registration_style_customizer_controls', array(), $this );

		// Include custom customize controls.
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-color-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-toggle-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-slider-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-select2-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-dimension-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-image-radio-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-image-checkbox-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-background-image-control.php';

		if ( ! empty( $controls ) ) {
			foreach ( $controls as $type => $controls_data ) {
				foreach ( $controls_data as $control_key => $control_data ) {
					$control_id = 'user_registration_styles[' . $this->form_id . '][' . $type . '][' . $control_key . ']';
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
						$this->add_customize_settings( $wp_customize, $control_id, $control_data['setting'] );
						$this->defaults[ $type ][ $control_key ] = $wp_customize->get_setting( $control_id )->default;
					} elseif ( ! empty( $control_data['settings'] ) ) {

						foreach ( $control_data['settings'] as $setting_key => $setting_args ) {
							$setting_id = 'user_registration_styles[' . $this->form_id . '][' . $type . '][' . $setting_key . ']';
							$this->add_customize_settings( $wp_customize, $setting_id, $setting_args );
							$this->defaults[ $type ][ $setting_key ] = $wp_customize->get_setting( $setting_id )->default;
						}

						// Control settings args handling.
						if ( ! empty( $control_data['control']['settings'] ) ) {
							foreach ( $control_data['control']['settings'] as $key => $setting ) {
								$control_args['settings'][ $key ] = 'user_registration_styles[' . $this->form_id . '][' . $type . '][' . $setting . ']';
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
	 * Add customize settings and controls for login form.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public function add_login_customize_controls( $wp_customize ) {

		$controls = apply_filters( 'user_registration_style_customizer_controls', array(), $this );

		// Include custom customize controls.
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-color-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-toggle-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-slider-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-select2-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-dimension-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-image-radio-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-image-checkbox-control.php';
		require_once dirname( __FILE__ ) . '/customize/class-ur-customize-background-image-control.php';

		if ( ! empty( $controls ) ) {
			foreach ( $controls as $type => $controls_data ) {
				foreach ( $controls_data as $control_key => $control_data ) {
					$control_id = 'user_registration_login_styles[' . $type . '][' . $control_key . ']';
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
						$this->add_customize_settings( $wp_customize, $control_id, $control_data['setting'] );
						$this->defaults[ $type ][ $control_key ] = $wp_customize->get_setting( $control_id )->default;
					} elseif ( ! empty( $control_data['settings'] ) ) {

						foreach ( $control_data['settings'] as $setting_key => $setting_args ) {
							$setting_id = 'user_registration_login_styles[' . $type . '][' . $setting_key . ']';
							$this->add_customize_settings( $wp_customize, $setting_id, $setting_args );
							$this->defaults[ $type ][ $setting_key ] = $wp_customize->get_setting( $setting_id )->default;
						}

						// Control settings args handling.
						if ( ! empty( $control_data['control']['settings'] ) ) {
							foreach ( $control_data['control']['settings'] as $key => $setting ) {
								$control_args['settings'][ $key ] = 'user_registration_login_styles[' . $type . '][' . $setting . ']';
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
	 * Save the styles data.
	 */
	public function registration_save_after() {

		if ( ! isset( $_REQUEST['customized'] ) ) { // WPCS: CSRF ok.
			return;
		}

		$save       = false;
		$customized = json_decode( wp_unslash( $_REQUEST['customized'] ), true ); // WPCS: input var ok, CSRF ok, sanitization ok.

		// Check if valid to compile and update css.
		foreach ( array_keys( $customized ) as $setting_id ) {
			if ( false !== strpos( $setting_id, 'user_registration_styles[' . $this->form_id . ']' ) ) {
				$save = true;
				break;
			}
		}

		if ( $save ) {
			$upload_dir = wp_upload_dir();
			$custom_css = $this->compile_scss();
			$files      = array(
				array(
					'base'    => $upload_dir['basedir'] . '/user_registration_styles',
					'file'    => 'index.html',
					'content' => '',
				),
				array(
					'base'    => $upload_dir['basedir'] . '/user_registration_styles',
					'file'    => 'user-registration-' . absint( $this->form_id ) . '.css',
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

	/**
	 * Save the styles data.
	 */
	public function login_save_after() {

		if ( ! isset( $_REQUEST['customized'] ) ) { // WPCS: CSRF ok.
			return;
		}

		$save       = false;
		$customized = json_decode( wp_unslash( $_REQUEST['customized'] ), true ); // WPCS: input var ok, CSRF ok, sanitization ok.

		// Check if valid to compile and update css.
		foreach ( array_keys( $customized ) as $setting_id ) {
			if ( false !== strpos( $setting_id, 'user_registration_login_styles' ) ) {
				$save = true;
				break;
			}
		}

		if ( $save ) {
			$upload_dir = wp_upload_dir();
			$custom_css = $this->compile_login_scss();
			$files      = array(
				array(
					'base'    => $upload_dir['basedir'] . '/user_registration_styles',
					'file'    => 'index.html',
					'content' => '',
				),
				array(
					'base'    => $upload_dir['basedir'] . '/user_registration_styles',
					'file'    => 'user-registration-login.css',
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

	/**
	 * Compile SCSS to CSS styles.
	 *
	 * @return string|WP_Error The css data, or WP_Error object on failure.
	 */
	protected function compile_scss() {

		require_once 'libraries/scssphp/scss.inc.php';

		ob_start();
		include 'views/scss.php';
		$scss = ob_get_clean();

		try {
			$compiler = new Leafo\ScssPhp\Compiler(); // phpcs:ignore PHPCompatibility.LanguageConstructs.NewLanguageConstructs.t_ns_separatorFound
			$compiler->setVariables( array( 'form_id' => $this->form_id ) );
			$compiler->setFormatter( 'Leafo\ScssPhp\Formatter\Compressed' );
			$compiler->addImportPath( plugin_dir_path( UR_STYLE_CUSTOMIZER_PLUGIN_FILE ) . '/assets/css/bourbon/' );
			$compiled_css = $compiler->compile( trim( $scss ) );
			return $compiled_css;
		} catch ( Exception $e ) {
			$logger = ur_get_logger();
			$logger->warning( $e->getMessage(), array( 'source' => 'scssphp' ) );
		}

		return new WP_Error( 'could-not-compile-scss', __( 'ScssPhp: Unable to compile content', 'user-registration-style-customizer' ) );
	}

	/**
	 * Compile SCSS to CSS styles.
	 *
	 * @return string|WP_Error The css data, or WP_Error object on failure.
	 */
	protected function compile_login_scss() {

		require_once 'libraries/scssphp/scss.inc.php';

		ob_start();
		include 'views/login_scss.php';
		$scss = ob_get_clean();

		try {
			$compiler = new Leafo\ScssPhp\Compiler(); // phpcs:ignore PHPCompatibility.LanguageConstructs.NewLanguageConstructs.t_ns_separatorFound
			$compiler->setFormatter( 'Leafo\ScssPhp\Formatter\Compressed' );
			$compiler->addImportPath( plugin_dir_path( UR_STYLE_CUSTOMIZER_PLUGIN_FILE ) . '/assets/css/bourbon/' );
			$compiled_css = $compiler->compile( trim( $scss ) );
			return $compiled_css;
		} catch ( Exception $e ) {
			$logger = ur_get_logger();
			$logger->warning( $e->getMessage(), array( 'source' => 'scssphp' ) );
		}

		return new WP_Error( 'could-not-compile-scss', __( 'ScssPhp: Unable to compile content', 'user-registration-style-customizer' ) );
	}

	/**
	 * Remove specific form styles.
	 *
	 * When form is deleted then it also deletes its styles data and css file.
	 *
	 * @param int $postid Post ID.
	 */
	public function delete_styles( $postid ) {

		$upload_dir    = wp_upload_dir( null, false );
		$style_options = get_option( 'user_registration_styles' );

		// Delete specific form styles data.
		if ( isset( $style_options[ $postid ] ) ) {

			unset( $style_options[ $postid ] );
			update_option( 'user_registration_styles', $style_options );

			// Delete the custom css file.
			wp_delete_file( $upload_dir['baseurl'] . '/user_registration_styles/user-registration-' . absint( $postid ) . '.css' );
		}
	}

	/**
	 * Get style templates.
	 */
	public function get_templates() {

		$templates = get_transient( 'ur_style_templates' );

		if ( false === $templates ) {
			$raw_templates = wp_safe_remote_get( 'https://raw.githubusercontent.com/wpeverest/user-registration-form-templates/master/style-templates.json' );

			if ( ! is_wp_error( $raw_templates ) ) {
				$templates = wp_remote_retrieve_body( $raw_templates );
				set_transient( 'ur_style_templates', $templates, WEEK_IN_SECONDS );
			}
		}

		return apply_filters( 'user_registration_style_templates', $templates );
	}

	/**
	 * Get template choices data.
	 */
	public function get_template_choices() {

		$templates     = array();
		$template_data = $this->get_templates();

		if ( ! empty( $template_data ) ) {
			$template_data = json_decode( $template_data )->styles;

			foreach ( $template_data as $template_key => $template ) {
				$templates[ $template_key ] = array(
					'name'  => $template->title,
					'image' => $template->thumb,
				);
			}
		}
		return $templates;
	}

	/**
	 * Get template json data.
	 */
	public function get_templates_data() {
		$templates_data = array();
		$template_data  = $this->get_templates();

		if ( ! empty( $template_data ) ) {
			$template_data = json_decode( $template_data )->styles;

			foreach ( $template_data as $template_key => $template ) {
				$templates_data[ 'data-template-' . $template_key ] = $template->data;
			}
		}
		return $templates_data;
	}

	/**
	 * Get style templates.
	 */
	public function get_login_templates() {

		$templates = get_transient( 'ur_login_style_templates' );

		if ( false === $templates ) {
			$raw_templates = wp_safe_remote_get( 'https://raw.githubusercontent.com/wpeverest/user-registration-form-templates/master/login-style-templates.json' );

			if ( ! is_wp_error( $raw_templates ) ) {
				$templates = wp_remote_retrieve_body( $raw_templates );
				set_transient( 'ur_login_style_templates', $templates, WEEK_IN_SECONDS );
			}
		}

		return apply_filters( 'user_registration_login_style_templates', $templates );
	}

	/**
	 * Get template choices data.
	 */
	public function get_login_template_choices() {

		$templates     = array();
		$template_data = $this->get_login_templates();

		if ( ! empty( $template_data ) ) {
			$template_data = json_decode( $template_data )->styles;

			foreach ( $template_data as $template_key => $template ) {
				$templates[ $template_key ] = array(
					'name'  => $template->title,
					'image' => $template->thumb,
				);
			}
		}
		return $templates;
	}

	/**
	 * Get template json data.
	 */
	public function get_login_templates_data() {
		$templates_data = array();
		$template_data  = $this->get_login_templates();

		if ( ! empty( $template_data ) ) {
			$template_data = json_decode( $template_data )->styles;

			foreach ( $template_data as $template_key => $template ) {
				$templates_data[ 'data-template-' . $template_key ] = $template->data;
			}
		}
		return $templates_data;
	}
}

new UR_Style_Customizer_API();
