<?php
/**
 * UserRegistrationAdvancedFields Frontend.
 *
 * @class    URAF_Frontend
 * @version  1.0.0
 * @package  UserRegistrationAdvancedFields/Admin
 * @category Admin
 * @author   WPEverest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URWC_Frontend Class
 */
class URAF_Frontend {

	public function __construct() {
		add_action( 'uraf_profile_picture_buttons', array( $this, 'uraf_profile_picture_buttons' ) );
		add_filter( 'user_registration_registered_form_fields', array( $this, 'get_all_registered_fields' ), 10, 1 );
		add_action( 'user_registration_enqueue_scripts', array( $this, 'load_scripts' ), 10, 2 );
		add_action( 'user_registration_my_account_enqueue_scripts', array( $this, 'load_scripts' ), 10, 2 );
		add_filter( 'user_registration_form_params', array( $this, 'user_registration_form_params' ), 10, 1 );
		add_filter( 'user_registration_form_field_section_title', array( $this, 'user_registration_form_field_render' ), 10, 4 );
		add_filter( 'user_registration_form_field_html', array( $this, 'user_registration_form_field_render' ), 10, 4 );
		add_filter( 'user_registration_form_field_wysiwyg', array( $this, 'user_registration_form_field_render' ), 10, 4 );
		add_filter( 'user_registration_form_field_phone', array( $this, 'user_registration_form_field_render' ), 10, 4 );
		add_filter( 'user_registration_form_field_select2', array( $this, 'user_registration_form_field_render' ), 10, 4 );
		add_filter( 'user_registration_form_field_multi_select2', array( $this, 'user_registration_form_field_render' ), 10, 4 );
		add_filter( 'user_registration_form_field_profile_picture', array( $this, 'user_registration_form_field_profile_picture' ), 10, 4 );
		add_filter( 'user_registration_form_field_range', array( $this, 'user_registration_form_field_render' ), 10, 4 );
	}

	/**
	 * Hook Advanced fields to core fields
	 *
	 * @param  array $fields
	 * @return array
	 */
	public function get_all_registered_fields( $fields ) {
		return array_merge( $fields, user_registration_list_advanced_fields() );
	}

	/**
	 * Load Frontend script in admin profile page.
	 */
	public function load_scripts( $form_data_array, $form_id ) {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_script( 'user-registration-time-picker', URAF()->plugin_url() . '/assets/js/jquery-timepicker/jquery.timepicker' . $suffix . '.js', array( 'jquery' ), URAF_VERSION );
		wp_register_script( 'user-registration-jcrop-script', URAF()->plugin_url() . '/assets/js/jquery-Jcrop/jquery.Jcrop.min.js', array( 'jquery' ), URAF_VERSION );
		wp_register_script( 'user-registration-advanced-fields-frontend', URAF()->plugin_url() . '/assets/js/frontend/uraf-frontend' . $suffix . '.js', array( 'jquery', 'user-registration-time-picker', 'selectWoo', 'jquery-ui-dialog', 'sweetalert2' ), URAF_VERSION );

		wp_register_style( 'user-registration-advanced-fields-time-picker-style', URAF()->plugin_url() . '/assets/css/jquery-timepicker/jquery.timepicker.css', array( 'select2' ), URAF_VERSION );
		wp_register_style( 'user-registration-advanced-fields-jcrop-style', URAF()->plugin_url() . '/assets/css/jquery.Jcrop.min.css', array(), URAF_VERSION );
		wp_register_style( 'user-registration-advanced-fields-profile-picture-upload-style', URAF()->plugin_url() . '/assets/css/uraf-frontend.css', array(), URAF_VERSION );

		wp_enqueue_script( 'user-registration-time-picker' );
		wp_enqueue_script( 'user-registration-jcrop-script' );
		wp_enqueue_script( 'user-registration-advanced-fields-frontend' );
		wp_enqueue_style( 'user-registration-advanced-fields-time-picker-style' );
		wp_enqueue_style( 'user-registration-advanced-fields-jcrop-style' );
		wp_enqueue_style( 'user-registration-advanced-fields-profile-picture-upload-style' );

		// Register and Enqueue style and scripts for phone field
		wp_register_script( 'jquery-intl-tel-input', URAF()->plugin_url() . '/assets/js/intlTelInput/jquery.intlTelInput' . $suffix . '.js', array( 'jquery' ), URAF_VERSION );
		wp_register_style( 'jquery-intl-tel-input-style', URAF()->plugin_url() . '/assets/css/intlTelInput.css', array(), URAF_VERSION );

		wp_enqueue_script( 'jquery-intl-tel-input' );
		wp_enqueue_style( 'jquery-intl-tel-input-style' );
		// Register and Enqueue scripts for webcamjs
		wp_register_script( 'user-registration-webcam-script', URAF()->plugin_url() . '/assets/js/webcam/webcam' . $suffix . '.js', array( 'jquery' ), URAF_VERSION );

		wp_enqueue_script( 'user-registration-webcam-script' );

		wp_localize_script(
			'user-registration-advanced-fields-frontend',
			'user_registration_advanced_fields_params',
			array(
				'ajax_url'                                 => admin_url( 'admin-ajax.php' ),
				'utils_url'                                => URAF()->plugin_url() . '/assets/js/intlTelInput/utils.js',
				'uraf_profile_picture_upload_nonce'        => wp_create_nonce( 'uraf_profile_picture_upload_nonce' ),
				'uraf_profile_picture_uploading'           => __( 'Uploading...', 'user-registration-advanced-fields' ),
				'uraf_profile_picture_something_wrong'     => __( 'Something wrong, please try again.', 'user-registration-advanced-fields' ),
				'uraf_profile_picture_crop_picture_title'  => esc_html__( 'Crop Your Picture', 'user-registration-advanced-fields' ),
				'uraf_profile_picture_crop_picture_button' => esc_html__( 'Crop Picture', 'user-registration-advanced-fields' ),
				'uraf_profile_picture_capture'             => esc_html__( 'Capture', 'user-registration-advanced-fields' ),
				'uraf_profile_picture_ssl_error_title'     => esc_html__( 'SSl Certificate Error', 'user-registration-advanced-fields' ),
				'uraf_profile_picture_ssl_error_text'      => esc_html__( 'The site must be secure. Please enable https connection.', 'user-registration-advanced-fields' ),
				'uraf_profile_picture_permission_error_title' => esc_html__( 'Permission Error', 'user-registration-advanced-fields' ),
				'uraf_profile_picture_permission_error_text' => esc_html__( 'Please allow access to webcam.', 'user-registration-advanced-fields' ),
				'uraf_profile_picture_cancel_button'       => esc_html__( 'Cancel', 'user-registration-advanced-fields' ),
				'uraf_profile_picture_cancel_button_confirmation' => esc_html__( 'OK', 'user-registration-advanced-fields' ),
			)
		);

	}

	/**
	 * @param $fields
	 */
	public function user_registration_form_params( $extra_params ) {
		return $extra_params .= ' "enctype=multipart/form-data"';

	}

	/**
	 * Render the advanced fields on frontend
	 *
	 * @param  [type] $field [description]
	 * @param  [type] $key   [description]
	 * @param  [type] $args  [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function user_registration_form_field_render( $field, $key, $args, $value ) {

		/* Conditional Logic codes */
			$rules                      = array();
			$rules['conditional_rules'] = isset( $args['conditional_rules'] ) ? $args['conditional_rules'] : '';
			$rules['logic_gate']        = isset( $args['logic_gate'] ) ? $args['logic_gate'] : '';
			$rules['rules']             = isset( $args['rules'] ) ? $args['rules'] : array();
			$rules['required']          = isset( $args['required'] ) ? $args['required'] : '';

		foreach ( $rules['rules'] as $rules_key => $rule ) {
			if ( empty( $rule['field'] ) ) {
				unset( $rules['rules'][ $rules_key ] );
			}
		}
			$rules['rules'] = array_values( $rules['rules'] );

			$rules = ( ! empty( $rules['rules'] ) && isset( $args['enable_conditional_logic'] ) ) ? wp_json_encode( $rules ) : '';
		/*Conditonal Logic codes end*/

		if ( true === $args['required'] ) {
			$args['class'][] = 'validate-required';
			$required        = ' <abbr class="required" title="' . esc_attr__( 'required', 'user-registration-advanced-fields' ) . '">*</abbr>';
		} else {
			$args['required'] = $required = '';
		}
		$description   = '<span class="description">' . isset( $args['description'] ) ? $args['description'] : '' . '</span>';
		$field_content = $field_label = '';

		$field_wrapper = '<p class="form-row " id="' . esc_attr( $args['id'] ) . '" data-priority="">';

		$custom_attributes = array();
		if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
			foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}

		if ( $args['label'] ) {

			$field_label .= '<label for="' . esc_attr( $args['label'] ) . '" class="ur-label">' . wp_kses(
				$args['label'],
				array(
					'a'    => array(
						'href'  => array(),
						'title' => array(),
					),
					'span' => array(),
				)
			) . $required . '</label>';
		}

		switch ( $args['type'] ) {
			case 'section_title':
				if ( $args['label'] ) {
					$field_content .= '<' . $args['header_attribute'] . ' id="' . esc_attr( $args['id'] ) . '">' . esc_html( $args['label'] ) . '</' . $args['header_attribute'] . '>';
					$field_content .= $description;
					$field_content .= ' <input type="hidden" data-rules="' . esc_attr( $rules ) . '" data-id="' . esc_attr( $key ) . '" value="' . $args['default'] . '" class=" ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" /> ';
				}
				break;
			case 'html':
				if ( isset( $args['html'] ) ) {
					$field_content .= $field_wrapper . $field_label;
					$field_content .= $description;
					$field_content .= ' <input type="hidden" data-rules="' . esc_attr( $rules ) . '" data-id="' . esc_attr( $key ) . '" value="' . $args['default'] . '" class=" ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" /> ';
					$field_content .= '<span id="' . esc_attr( $args['id'] ) . '">' . $args['html'] . '</span></p>';
				}
				break;
			case 'wysiwyg':
				$field_content .= '<p>' . $field_label . '</p>';
				$field_content .= $description;
				$field_content .= ' <input type="hidden" data-rules="' . esc_attr( $rules ) . '" data-id="' . esc_attr( $key ) . '" value="' . $args['default'] . '" class=" ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="" id="" /> ';
				$value = isset( $args['value'] ) ? $args['value'] : '';
				$args['value'] = html_entity_decode($value);
				$field_content .= uraf_get_wp_editor( $args );
				break;
			case 'phone':
				$field_content .= $field_wrapper . $field_label;
				$field_content .= $description;
				$phone_format   = isset( $args['phone_format'] ) ? $args['phone_format'] : 'default';

				if ( empty( $args['default'] ) ) {
					$default_format = '';
				} else {
					$default_format = $args['default'];
				}

				if ( 'default' === $phone_format ) {
					if ( '+' !== substr( $default_format, 0, 1 ) ) {
						$input_mask     = isset( $args['input_mask'] ) ? $args['input_mask'] : '(999) 999-9999';
						$field_content .= ' <input data-rules="' . esc_attr( $rules ) . '" data-inputmask="\'mask\':\'' . $input_mask . '\'" data-id="' . esc_attr( $key ) . '" type="text" value="' . $args['default'] . '" class=" ' . esc_attr( implode( ' ', $args['input_class'] ) ) . 'ur-masked-input" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . '/> ';
					} else {
						$field_content .= ' <input data-rules="' . esc_attr( $rules ) . '" data-id="' . esc_attr( $key ) . '" type="text" value="' . $args['default'] . '" class=" ' . esc_attr( implode( ' ', $args['input_class'] ) ) . 'ur-smart-phone-field" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . $args['placeholder'] . '" ' . implode( ' ', $custom_attributes ) . ' /> ';
					}
				} else {
					$field_content .= ' <input data-rules="' . esc_attr( $rules ) . '" data-id="' . esc_attr( $key ) . '" type="text" value="' . $args['default'] . '" class=" ' . esc_attr( implode( ' ', $args['input_class'] ) ) . 'ur-smart-phone-field" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . $args['placeholder'] . '" ' . implode( ' ', $custom_attributes ) . ' /> ';
				}
				break;
			case 'select2':
				$default_value  = isset( $args['default_value'] ) ? $args['default_value'] : '';
				$value          = ( isset( $args['value'] ) ) ? $args['value'] : $default_value;
				$field_content .= $field_wrapper . $field_label;
				$field_content .= $description;
				$field_content .= '<select data-rules="' . esc_attr( $rules ) . '" data-id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . '>';
				foreach ( $args['options'] as $option_value ) {
					$field_content .= sprintf( '<option value="%1$s" %2$s>%1$s</option>', $option_value, selected( $option_value, $value, false ) );
				}
				$field_content .= '</select></p>';
				break;
			case 'multi_select2':
				$default_value                 = isset( $args['default_value'] ) ? $args['default_value'] : array();
				$value                         = ( isset( $args['value'] ) ) ? $args['value'] : $default_value;
				$custom_attributes['multiple'] = 'multiple';
				$choice_limit                  = isset( $args['choice_limit'] ) ? $args['choice_limit'] : "";
				$choice_limit_attr             = "";

				if ( "" !== $choice_limit ) {
					$choice_limit_attr = 'data-choice-limit="' . $choice_limit . '"';
				}
				$field_content .= $field_wrapper . $field_label;
				$field_content .= $description;
				$field_content .= '<select data-rules="' . esc_attr( $rules ) . '" data-id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '[]" id="' . esc_attr( $args['id'] ) . '" class="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' ' . $choice_limit_attr . '>';
				foreach ( $args['options'] as $option_value ) {
					$selected       = is_array( $value ) && in_array( $option_value, $value, true ) ? "selected='selected'" : '';
					$field_content .= sprintf( '<option value="%1$s" %2$s>%1$s</option>', $option_value, $selected );
				}
				$field_content .= '</select></p>';
				break;
			/**
			 * Handle change in range field display in form.
			 *
			 * @since 1.4.0
			 */
			case 'range':
				$field_content .= $field_wrapper . $field_label;
				$field_content .= $description;
				$field_content .= '<div class="ur-range-row">';
				$field_content .= '<div class="ur-range-field-sec">';

				// Check if range prefix is set.
				if ( isset( $args['range_prefix'] ) ) {
					$field_content .= '<span class="ur-label ur-range-prefix">' . $args['range_prefix'] . '</span>';
				}

				$field_content .= ' <input data-rules="' . esc_attr( $rules ) . '" data-id="' . esc_attr( $key ) . '" type="range" value="' . $args['default'] . '" class=" ur-range-slider ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" min="' . $args['range_min'] . '" max="' . $args['range_max'] . '" step="' . $args['range_step'] . '" placeholder="' . $args['placeholder'] . '" ' . implode( ' ', $custom_attributes ) . ' /> ';
				$field_content .= '<output class="bubble" style="display:none;"></output>';

				// Check if range postfix is set.
				if ( isset( $args['range_postfix'] ) ) {
					$field_content .= '<span class="ur-label ur-range-postfix">' . $args['range_postfix'] . '</span>';
				}

				$field_content .= '</div>';
				$field_content .= '<div class="ur-range-number">';
				$field_content .= ' <input type="number" class="ur-range-input input-text" min="' . $args['range_min'] . '" value="' . $args['range_min'] . '" max="' . $args['range_max'] . '" step="' . $args['range_step'] . '"  name="' . esc_attr( $key ) . '"/>';
				$field_content .= ' <span class="ur-range-slider-reset-icon dashicons dashicons-image-rotate"></span>';
				$field_content .= '</div>';
				$field_content .= '</div>';
				$field_content .= '</p>';
				break;
			}

		echo $field_content;

		return '';

	}

	/**
	 * @param $field
	 * @param $key
	 * @param $args
	 * @param $value
	 */
	public function user_registration_form_field_profile_picture( $field, $key, $args, $value ) {

		$value             = isset( $args['value'] ) ? $args['value'] : '';
		$custom_attributes = array();

		if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
			foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}

		/* Conditional Logic codes */
		$rules                      = array();
		$rules['conditional_rules'] = isset( $args['conditional_rules'] ) ? $args['conditional_rules'] : '';
		$rules['logic_gate']        = isset( $args['logic_gate'] ) ? $args['logic_gate'] : '';
		$rules['rules']             = isset( $args['rules'] ) ? $args['rules'] : array();
		$rules['required']          = isset( $args['required'] ) ? $args['required'] : '';

		foreach ( $rules['rules'] as $rules_key => $rule ) {
			if ( empty( $rule['field'] ) ) {
				unset( $rules['rules'][ $rules_key ] );
			}
		}

		$rules['rules'] = array_values( $rules['rules'] );

		$rules = ( ! empty( $rules['rules'] ) && isset( $args['enable_conditional_logic'] ) ) ? wp_json_encode( $rules ) : '';
		/*Conditonal Logic codes end*/

		$is_required = isset( $args['required'] ) ? $args['required'] : 0;

		?>
		<div class="uraf-profile-picture-upload">
			<p class="form-row " id="<?php echo $key; ?>_field" data-priority="">
				<label for="<?php echo $key; ?>" class="ur-label"><?php echo esc_html( $args['label'] ); ?> <?php if ( $is_required ) { ?>
						<abbr class="required"
							  title="required">*</abbr><?php } ?></label>
				<?php
				if ( $args['description'] ) {
					echo '<span class="description">' . $args['description'] . '</span></br>';
				}
				?>
				<?php

				if ( 0 === get_current_user_id() ) {
					$gravatar_image = get_avatar_url( get_current_user_id(), $args = null );
				} else {

					if ( get_user_meta( get_current_user_id(), $key, true ) ) {
						$gravatar_image = get_user_meta( get_current_user_id(), $key, true );
					} else {
						$gravatar_image = plugins_url( '../assets/img/default_profile.png', __FILE__ );
					}
				}
				?>
				<img class="profile-preview" alt="profile-picture" src="<?php echo $gravatar_image; ?>" style='max-width:96px; max-height:96px;' >
				<span class="uraf-profile-picture-upload-node" style="height: 0;width: 0;margin: 0;padding: 0;float: left;border: 0;overflow: hidden;">
				<input type="file" id="ur-profile-pic" name="profile-pic" class="profile-pic-upload" accept="image/jpeg" />
					<?php echo '<input data-rules="' . esc_attr( $rules ) . '" type="text" class="uraf-profile-picture-input input-text ur-frontend-field" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . '/>'; ?>
				</span>
			</p>
			<?php do_action( 'uraf_profile_picture_buttons' ); ?>
			<div style="clear:both; margin-bottom: 20px"></div>

		</div>

		<?php

		return '';

	}

	public function uraf_profile_picture_buttons() {
		$gravatar_image      = get_avatar_url( get_current_user_id(), $args = null );
		$profile_picture_url = get_user_meta( get_current_user_id(), 'user_registration_profile_pic_url', true );
		if ( ! $profile_picture_url ) {
			?>
			<button type="button" class="button uraf-profile-picture-remove hide-if-no-js" style="display:none"><?php echo __( 'Remove', 'user-registration-advanced-fields' ); ?></button>
			<button type="button" class="button wp_uraf_take_snapshot hide-if-no-js"><?php echo __( 'Take Picture', 'user-registration-advanced-fields' ); ?></button>
			<button type="button" class="button wp_uraf_profile_picture_upload hide-if-no-js"><?php echo __( 'Upload file', 'user-registration-advanced-fields' ); ?></button>
			<?php
		} else {
			?>
			<button type="button" class="button uraf-profile-picture-remove hide-if-no-js"><?php echo __( 'Remove', 'user-registration-advanced-fields' ); ?></button>
			<button type="button" class="button wp_uraf_take_snapshot hide-if-no-js" style="display:none"><?php echo __( 'Take Picture', 'user-registration-advanced-fields' ); ?></button>
			<button type="button" class="button wp_uraf_profile_picture_upload hide-if-no-js" style="display:none"><?php echo __( 'Upload file', 'user-registration-advanced-fields' ); ?></button>
			<?php
		}
	}

}

return new URAF_Frontend();
