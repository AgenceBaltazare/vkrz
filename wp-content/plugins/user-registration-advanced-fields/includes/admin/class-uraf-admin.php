<?php
/**
 * UserRegistrationAdvancedFields Admin.
 *
 * @class    URAF_Admin
 * @version  1.0.0
 * @package  UserRegistrationAdvancedFields/Admin
 * @category Admin
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URAF_Admin Class
 */
class URAF_Admin {

	/**
	 * Advanced Feild Array.
	 *
	 * @var array
	 */
	public $advanced_fields = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		uraf_check_plugin_compatibility();
		$message = uraf_is_compatible();

		if ( 'YES' !== $message ) {
			return;
		}

		$this->advanced_fields = user_registration_list_advanced_fields();
		add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'user_registration_extra_fields', array( $this, 'user_registration_render_advanced_fields' ) );
		foreach ( $this->advanced_fields as $field ) {
			add_filter( 'user_registration_' . $field . '_admin_template', array( $this, 'user_registration_af_fields_admin_template_includes' ), 10, 1 );
		}
		add_filter( 'user_registration_field_options_general_settings', array( $this, 'field_settings' ), 10, 2 );

		// Frontend message settings.
		add_filter( 'user_registration_frontend_messages_settings', array( $this, 'add_advanced_fields_frontend_message' ) );
	}


	/**
	 * Register and Equeuing Script and Style.
	 */
	public function load_scripts() {

		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';
		$suffix    = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_script( 'ur-inputmask', URAF()->plugin_url() . '/assets/js/inputmask/jquery.inputmask.bundle' . $suffix . '.js', array( 'jquery' ), '4.0.0-beta.58', true );
		wp_register_script( 'uraf_admin', URAF()->plugin_url() . '/assets/js/admin/uraf-admin' . $suffix . '.js', array( 'jquery', 'selectWoo', 'ur-inputmask' ), URAF_VERSION, true );
		wp_register_style( 'uraf-admin', URAF()->plugin_url() . '/assets/css/uraf-admin.css', array(), URAF_VERSION );

		if ( 'user-registration_page_add-new-registration' === $screen_id ) {
			wp_enqueue_script( 'uraf_admin' );
			wp_enqueue_style( 'uraf-admin' );
		}
	}

	/**
	 * Display advanced Field Section
	 *
	 * @since 1.0
	 */
	public function user_registration_render_advanced_fields() {

		echo '<h2 class="ur-toggle-heading" >' . esc_html__( 'Advanced Fields', 'user-registration-advanced-fields' ) . '</h2><hr/>';

		$this->get_advanced_fields();
	}

	/**
	 * Render all the advanced fields
	 *
	 * @since  1.0
	 */
	public function get_advanced_fields() {

		$registered_form_fields = $this->advanced_fields;

		echo ' <ul id = "ur-draggabled" class="ur-registered-list ur-advanced-fields" > ';

		$get_list = new UR_Admin_Menus();

		foreach ( $registered_form_fields as $field ) {

				$get_list->ur_get_list( $field );
		}
			echo ' </ul > ';
	}

	/**
	 * Advanced Fields Admin template includes.
	 *
	 * @param string $path Path.
	 *
	 * @return string
	 */
	public function user_registration_af_fields_admin_template_includes( $path ) {

		$core_path  = UR_ABSPATH;
		$addon_path = URAF_ABSPATH;
		$path       = str_replace( $core_path, $addon_path, $path );

		return $path;
	}

	/**
	 * Field settings.
	 *
	 * @param array $general_settings general field settings.
	 * @param mixed $id Field Key.
	 *
	 * @return array
	 */
	public function field_settings( $general_settings, $id ) {

		switch ( $id ) {
			case 'user_registration_section_title':
				$remove_keys = array( 'placeholder', 'required', 'hide_label' );
				foreach ( $remove_keys as $remove_key ) {
					unset( $general_settings[ $remove_key ] );
				}
				$new_settings     = array(
					'header_attribute' => array(
						'type'        => 'select',
						'label'       => __( 'Select Header', 'user-registration-advanced-fields' ),
						'name'        => 'ur_general_setting[header_attribute]',
						'placeholder' => '',
						'options'     => array(
							'h1' => __( 'Heading 1', 'user-registration' ),
							'h2' => __( 'Heading 2', 'user-registration' ),
							'h3' => __( 'Heading 3', 'user-registration' ),
							'h4' => __( 'Heading 4', 'user-registration' ),
							'h5' => __( 'Heading 5', 'user-registration' ),
							'h6' => __( 'Heading 6', 'user-registration' ),
						),
						'required'    => true,
						'tip'         => __( 'Choose size for the label.', 'user-registration-advanced-fields' ),
					),
				);
				$general_settings = array_merge( $general_settings, $new_settings );
				break;

			case 'user_registration_timepicker':
			case 'user_registration_wysiwyg':
				unset( $general_settings['placeholder'] );
				$input_mask       = array(
					'input_mask' => array(
						'type'        => 'text',
						'label'       => __( 'Input Mask', 'user-registration-advanced-fields' ),
						'name'        => 'ur_general_setting[input_mask]',
						'placeholder' => '',
						'required'    => true,
						'tip'         => __( 'Set mask to allow users input only in the specified format.', 'user-registration-advanced-fields' ),
					),
				);
				$general_settings = array_merge( $general_settings, $input_mask );
				break;

			case 'user_registration_phone':
				unset( $general_settings['placeholder'] );
				$phone_settings   = array(
					'phone_format' => array(
						'type'        => 'select',
						'label'       => __( 'Select Format', 'user-registration-advanced-fields' ),
						'name'        => 'ur_general_setting[phone_format]',
						'placeholder' => '',
						'options'     => array(
							'default' => __( 'Default', 'user-registration' ),
							'smart'   => __( 'Smart', 'user-registration' ),
						),
						'required'    => true,
						'tip'         => __( 'Format or Mask the input phone number should fit in.', 'user-registration-advanced-fields' ),
					),
					'input_mask'   => array(
						'type'        => 'text',
						'label'       => __( 'Input Mask', 'user-registration-advanced-fields' ),
						'name'        => 'ur_general_setting[input_mask]',
						'placeholder' => '',
						'required'    => true,
						'tip'         => __( 'Set mask to allow users input only in the specified format.', 'user-registration-advanced-fields' ),
					),
				);
				$general_settings = array_merge( $general_settings, $phone_settings );
				break;

			case 'user_registration_html':
				$remove_keys = array( 'placeholder', 'required' );
				foreach ( $remove_keys as $remove_key ) {
					unset( $general_settings[ $remove_key ] );
				}
				$new_settings     = array(
					'html' => array(
						'type'        => 'textarea',
						'label'       => __( 'HTML', 'user-registration-advanced-fields' ),
						'name'        => 'ur_general_setting[html]',
						'placeholder' => __( 'Custom HTML', 'user-registration-advanced-fields' ),
						'required'    => true,
						'tip'         => __( 'HTML to render in the frontend.', 'user-registration-advanced-fields' ),
					),
				);
				$general_settings = array_merge( $general_settings, $new_settings );
				break;
			case 'user_registration_select2':
				$remove_keys = array( 'placeholder' );
				foreach ( $remove_keys as $remove_key ) {
					unset( $general_settings[ $remove_key ] );
				}

				$new_settings     = array(
					'options' => array(
						'type'        => 'radio',
						'label'       => __( 'Options', 'user-registration-advanced-fields' ),
						'name'        => 'ur_general_setting[options]',
						'placeholder' => '',
						'required'    => true,
						'options'     => array(
							__( 'First Choice', 'user-registration' ),
							__( 'Second Choice', 'user-registration' ),
							__( 'Third Choice', 'user-registration' ),
						),
						'tip'         => __( 'Add options to let users select from.', 'user-registration-advanced-fields' ),
					),
				);
				$general_settings = ur_insert_after_helper( $general_settings, $new_settings, 'field_name' );
				break;
			case 'user_registration_multi_select2':
				$remove_keys = array( 'placeholder' );
				foreach ( $remove_keys as $remove_key ) {
					unset( $general_settings[ $remove_key ] );
				}

				$new_settings     = array(
					'options' => array(
						'type'        => 'checkbox',
						'label'       => __( 'Options', 'user-registration-advanced-fields' ),
						'name'        => 'ur_general_setting[options]',
						'placeholder' => '',
						'required'    => true,
						'options'     => array(
							__( 'First Choice', 'user-registration' ),
							__( 'Second Choice', 'user-registration' ),
							__( 'Third Choice', 'user-registration' ),
						),
						'tip'         => __( 'Add options to let users select from.', 'user-registration-advanced-fields' ),
					),
				);
				$general_settings = ur_insert_after_helper( $general_settings, $new_settings, 'field_name' );
				break;
			case 'user_registration_profile_picture':
				$remove_keys = array( 'placeholder' );

				foreach ( $remove_keys as $remove_key ) {
					unset( $general_settings[ $remove_key ] );
				}
				break;
			case 'user_registration_range':
				$remove_keys = array( 'placeholder' );

				foreach ( $remove_keys as $remove_key ) {
					unset( $general_settings[ $remove_key ] );
				}
				break;
		}

		return $general_settings;
	}

	/**
	 * Add advanced fields frontend message.
	 *
	 * @param array $settings Settings.
	 *
	 * @return array
	 */
	public function add_advanced_fields_frontend_message( $settings ) {
		$phone_settings = array(
			array(
				'title' => __( 'Advanced Fields Messages', 'user-registration-advanced-fields' ),
				'type'  => 'title',
				'desc'  => '',
				'id'    => 'advanced_fields_messages_settings',
			),
			array(
				'title'    => __( 'Phone Number', 'user-registration-advanced-fields' ),
				'desc'     => __( 'Enter the error message in form submission on Phone Number.', 'user-registration-advanced-fields' ),
				'id'       => 'user_registration_form_submission_error_message_phone_number',
				'type'     => 'text',
				'desc_tip' => true,
				'css'      => 'min-width: 350px;',
				'default'  => __( 'Please enter a valid phone number.', 'user-registration-advanced-fields' ),
			),
			array(
				'type' => 'sectionend',
				'id'   => 'advanced_fields_messages_settings',
			),
		);

		$settings = array_merge( $settings, $phone_settings );
		return $settings;
	}
}

return new URAF_Admin();
