<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class URCL_Conditional_field {

	protected $id = 0;

	public function __construct() {
		urcl_check_plugin_compatibility();
		$message = urcl_is_compatible();

		if ( $message !== 'YES' ) {
			return;
		}
		add_action( 'user_registration_after_advance_settings', array( $this, 'conditional_field' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_filter( 'user_registration_get_form_settings', array( $this, 'urcl_admin_conditional_role_setting' ), 10, 1 );
		add_action( 'user_registration_after_form_settings_save', array( $this, 'save_conditional_role_settings' ), 10, 1 );
	}

	/**
	 * Enqueue scripts.
	 */
	public function admin_scripts() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';
		$suffix    = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$data      = array(
			'checkbox_checked'               => __( 'Checked', 'user-registration-conditional-logic' ),
			'users_roles_conditional_fields' => $this->get_users_roles_conditional_output(),
			'users_roles_conditions_data'    => $this->get_users_roles_conditions_data(),
			'only_if_following_matches'      => __( 'only if following matches.', 'user-registration-conditional-logic' ),
			'assign'                         => __( 'Assign', 'user-registration-conditional-logic' ),
			'remove_condition'               => __( 'Remove Condition', 'user-registration-conditional-logic' ),
			'templates'                      => $this->get_templates(),
		);

		wp_register_script( 'urcl-admin-script', URCL()->plugin_url() . '/assets/js/admin/urcl-admin' . $suffix . '.js' );
		wp_localize_script( 'urcl-admin-script', 'urcl_data', $data );
		wp_enqueue_style( 'urcl-admin-style', URCL()->plugin_url() . '/assets/css/admin.css' );
		wp_enqueue_script( 'urcl-admin-script' );
	}

	/**
	 * Get a list of templates.
	 *
	 * @return array
	 */
	public function get_templates() {
		ob_start();

		// Conditional Logic Group.
		echo '<div class="user-registration-card urcl-conditional-logic__group urcl-group ur-bg-light">';
		echo '<div class="user-registration-card__header urcl-conditional-logic__group-header urcl-group-header ur-d-flex ur-align-items-center ur-border-0 ur-p-1 ur-pb-0">';
		echo '<div class="user-registration-button-group urcl-logic-gate-container">';
		echo '<span class="button button-tertiary urcl-logic-gate urcl-logic-gate-and {{{urcl_logic_gate:AND}}}" data-value="AND">AND</span>';
		echo '<span class="button button-tertiary urcl-logic-gate urcl-logic-gate-or {{{urcl_logic_gate:OR}}}" data-value="OR">OR</span>';
		echo '</div>';
		echo '</span>';
		echo '<span class="urcl-remove-group ur-ml-auto"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>';
		echo '</div>';
		echo '<div class="user-registration-card__body urcl-conditions-container ur-p-1">';

		echo '{{{urcl_conditions}}}';

		echo '</div>';
		echo '</div>';
		echo '</div>';
		$group = ob_get_clean();

		ob_start();

		// Conditional Logic Field.
		echo '<div class="urcl-conditional-logic__rule urcl-conditional-logic__rule--no-gutter urcl-field ur-d-flex">';
		echo '{{{urcl_triggerer_input}}}';
		echo '<select class="urcl-conditional-logic__rule__operator urcl-field-operator ur-form-field--sm">';
		echo '<option value="is" {{{operator:is}}}>is</option>';
		echo '<option value="is_not" {{{operator:is_not}}}>is not</option>';
		echo '</select>';
		echo '{{{urcl_field_value_input}}}';
		echo '<div class="urcl-conditional-logic__rule__actions urcl-field-actions">';
		echo '<span class="dashicons dashicons-plus-alt urcl-conditional-logic__rule-add urcl-add-field"></span>';
		echo '<span class="dashicons dashicons-dismiss urcl-conditional-logic__rule-remove urcl-remove-field"></span>';
		echo '</div>';
		echo '</div>';
		$field = ob_get_clean();

		return array(
			'field' => $field,
			'group' => $group,
		);
	}

	/**
	 *  Get Conditional Data for User Role in Form Settings.
	 *
	 * @return array
	 */
	public function get_users_roles_conditions_data() {
		$form_id              = isset( $_GET['edit-registration'] ) ? absint( $_GET['edit-registration'] ) : 0;
		$form_data            = ( $form_id ) ? UR()->form->get_form( $form_id ) : array();
		$user_roles_list      = ur_get_default_admin_roles();
		$all_form_fields      = get_conditional_fields_by_form_id( $form_id, '' );
		$user_role_conditions = $this->get_user_role_conditions_list( $form_id, $user_roles_list, $all_form_fields );
		return array(
			'user_role_conditions' => $user_role_conditions,
			'user_roles_list'      => $user_roles_list,
			'all_form_fields'      => $all_form_fields,
		);
	}

	/**
	 *  Get Layout of assiging user role conditionally in Form Settings.
	 *
	 * @return string $output
	 */
	public function get_users_roles_conditional_output() {
		$form_id              = isset( $_GET['edit-registration'] ) ? absint( $_GET['edit-registration'] ) : 0;
		$user_roles_list      = ur_get_default_admin_roles();
		$get_all_fields       = get_conditional_fields_by_form_id( $form_id, '' );
		$user_role_conditions = $this->get_user_role_conditions_list( $form_id, $user_roles_list, $get_all_fields );

		if ( $user_role_conditions ) {
			return $user_role_conditions;
		} else {
			$output  = '<div class="urcl-role-container">';
			$output .= '<div class="urcl-role-conditional-container">';
			$output .= '<div class="urcl-role-logic-wrap" data-group ="condition_1">';
			$output .= '<div class="urcl-assign-role">';
			$output .= '<p class="urcl-assign-label">' . esc_html__( 'Assign', 'user-registration-conditional-logic' ) . '</p>';
			$output .= '<select class="urcl-user-role-field" name="user_registration_form_conditional_user_role[condition_1]">';

			foreach ( $user_roles_list as $role => $user_role ) {
				$output .= '<option value="' . esc_attr__( $role, 'user-registration-conditional-logic' ) . '"> ' . $user_role . ' </option>';
			}
			$output .= '</select>';
			$output .= '<p>' . esc_html__( 'only if following matches.', 'user-registration-conditional-logic' ) . '</p>';
			$output .= '</div>';
			$output .= '<ul class="urcl-role-logic-box" data-group ="condition_1" data-last-key="1">';
			$output .= '<li class="urcl-conditional-group" data-key="1">';
			$output .= '<div class="urcl-form-group">';
			$output .= '<select class="urcl-user-role-field urcl-field-conditional-field-select" name="user_registration_form_fields[condition_1][1]">';
			$output .= '<option value="">' . esc_html__( '-- Select --', 'user-registration-conditional-logic' ) . '</option>';

			foreach ( $get_all_fields as $ind_field_key => $ind_field_value ) {
				$output .= '<option value="' . esc_attr__( $ind_field_key, 'user-registration-conditional-logic' ) . '" data-type="' . esc_attr__( $ind_field_value['field_key'], 'user-registration-conditional-logic' ) . '"> ' . $ind_field_value['label'] . ' </option>';
			}
			$output .= '</select></div>';
			$output .= '<div class="urcl-operator"><select class="urcl-user-role-field" name="user_registration_form_operator[condition_1][1]">';
			$output .= '<option value = "is"> ' . esc_html__( 'is', 'user-registration-conditional-logic' ) . ' </option>';
			$output .= '<option value = "is_not"> ' . esc_html__( 'is not', 'user-registration-conditional-logic' ) . ' </option>';
			$output .= '<option value = "empty"> ' . esc_html__( 'empty', 'user-registration-conditional-logic' ) . ' </option>';
			$output .= '<option value = "not_empty"> ' . esc_html__( 'not empty', 'user-registration-conditional-logic' ) . ' </option>';
			$output .= '<option value = "greater_than"> ' . esc_html__( 'greater than', 'user-registration-conditional-logic' ) . ' </option>';
			$output .= '<option value = "less_than"> ' . esc_html__( 'less than', 'user-registration-conditional-logic' ) . ' </option>';
			$output .= '</select></div>';
			$output .= '<div class="urcl-value"><input class="urcl-user-role-field" name="user_registration_form_value[condition_1][1]" type="text" /></div>';
			$output .= '<span class="add">';
			$output .= esc_html__( 'AND', 'user-registration-conditional-logic' );
			$output .= '</span>';
			$output .= '<span class="remove">';
			$output .= '<i class="dashicons dashicons-minus"></i>';
			$output .= '</span></li>';
			$output .= '</ul>';
			$output .= '<button class="button button-secondary button-medium urcl-add-or-condition" data-last-key="1">Add OR Condition</button>';
			$output .= '</div>';
			$output .= '</div>';
			$output .= '<button class="button button-secondary button-medium urcl-add-new-condition" data-last-conditionid="1">Add New Condition</button></div>';
		}
		return $output;
	}

	/**
	 *  Get Conditions List while assiging user role conditionally from post meta in Form Settings.
	 *
	 * @param int   $formid Form Id.
	 * @param array $user_roles_list User Role List
	 * @param array $get_all_fields Form Fields
	 *
	 * @return string $output
	 */
	public function get_user_role_conditions_list( $form_id, $user_roles_list, $get_all_fields ) {
		$condition_role_settings = maybe_unserialize( get_post_meta( $form_id, 'user_registration_user_role_condition', true ) );

		if ( ! empty( $condition_role_settings ) ) {
			$output  = '<div class="urcl-role-container">';
			$output .= '<div class="urcl-role-conditional-container">';

			$condition_id = 1;

			foreach ( $condition_role_settings as $conditions ) {
				$output .= '<div class="urcl-role-logic-wrap" data-group ="condition_' . $condition_id . '">';

				$output .= '<div class="urcl-assign-role">';
				$output .= '<p class="urcl-assign-label">' . esc_html__( 'Assign', 'user-registration-conditional-logic' ) . '</p>';
				$output .= '<select class="urcl-user-role-field" name="user_registration_form_conditional_user_role[condition_' . $condition_id . ']">';

				foreach ( $user_roles_list as $role => $user_role ) {
					$output .= '<option value="' . esc_attr__( $role, 'user-registration-conditional-logic' ) . '"' . ( $conditions['assign_role'] === $role ? 'selected' : '' ) . '> ' . $user_role . ' </option>';
				}
				$output .= '</select>';
				$output .= '<p>' . esc_html__( 'only if following matches.', 'user-registration-conditional-logic' ) . '</p>';
				$output .= '</div>';

				if ( isset( $conditions['conditions'] ) && isset( $conditions['conditions'] ) ) {
					$output .= '<ul class="urcl-role-logic-box" data-group ="condition_' . $condition_id . '" data-last-key="' . count( $conditions['conditions'] ) . '">';

					$data_key = 1;

					foreach ( $conditions['conditions'] as $condition ) {
						$output .= '<li class="urcl-conditional-group" data-key="' . $data_key . '">';
						$output .= '<div class="urcl-form-group">';

						$fields_data = wp_list_pluck( $condition, 'field_value' );

						$output .= '<select class="urcl-user-role-field urcl-field-conditional-field-select" name="user_registration_form_fields[condition_' . $condition_id . '][' . $data_key . ']">';
						$output .= '<option value="">' . esc_html__( '-- Select --', 'user-registration-conditional-logic' ) . '</option>';

						$selected_urcl_field_type = '';
						$selected_urcl_field_key  = '';
						foreach ( $get_all_fields as $ind_field_key => $ind_field_value ) {
							$selectedField = $fields_data[0] == $ind_field_key ? 'selected="selected"' : '';

							if ( $fields_data[0] == $ind_field_key ) {
								$selected_urcl_field_type = $ind_field_value['field_key'];
								$selected_urcl_field_key  = $ind_field_key;
							}
							$output .= '<option value="' . esc_attr__( $ind_field_key, 'user-registration-conditional-logic' ) . '" data-type="' . esc_attr__( $ind_field_value['field_key'], 'user-registration-conditional-logic' ) . '" ' . $selectedField . '> ' . $ind_field_value['label'] . ' </option>';
						}
						$output .= '</select></div>';
						$output .= '<div class="urcl-operator"><select class="urcl-user-role-field" name="user_registration_form_operator[condition_' . $condition_id . '][' . $data_key . ']">';
						$output .= '<option value = "is"  ' . ( 'is' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'is', 'user-registration-conditional-logic' ) . ' </option>';
						$output .= '<option value = "is_not" ' . ( 'is_not' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'is not', 'user-registration-conditional-logic' ) . ' </option>';
						$output .= '<option value = "empty" ' . ( 'empty' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'empty', 'user-registration-conditional-logic' ) . ' </option>';
						$output .= '<option value = "not_empty" ' . ( 'not_empty' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'not empty', 'user-registration-conditional-logic' ) . ' </option>';
						$output .= '<option value = "greater_than" ' . ( 'greater_than' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'greater than', 'user-registration-conditional-logic' ) . ' </option>';
						$output .= '<option value = "less_than" ' . ( 'less_than' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'less than', 'user-registration-conditional-logic' ) . ' </option>';
						$output .= '</select></div>';
						$output .= '<div class="urcl-value">';

						if ( $selected_urcl_field_type == 'checkbox' || $selected_urcl_field_type == 'radio' || $selected_urcl_field_type == 'select' || $selected_urcl_field_type == 'country' || $selected_urcl_field_type == 'billing_country' || $selected_urcl_field_type == 'shipping_country' || $selected_urcl_field_type == 'select2' || $selected_urcl_field_type == 'multi_select2' ) {
							$choices = get_checkbox_choices( $form_id, $selected_urcl_field_key );
							$output .= '<select name="user_registration_form_value[condition_' . $condition_id . '][' . $data_key . ']" class="urcl-user-role-field">';

							if ( is_array( $choices ) && array_filter( $choices ) ) {
								$output .= '<option>--select--</option>';
								foreach ( $choices as $key => $choice ) {
									$key           = $selected_urcl_field_type == 'country' ? $key : $choice;
									$selectedvalue = $fields_data[2] == $key ? 'selected="selected"' : '';
									$output       .= '<option ' . $selectedvalue . ' value="' . $key . '">' . esc_html( $choice ) . '</option>';
								}
							} else {
								$selected = isset( $fields_data[2] ) ? $fields_data[2] : 0;
								$output  .= '<option value="1" ' . ( $selected == '1' ? 'selected="selected"' : '' ) . ' >' . __( 'Checked', 'user-registration-conditional-logic' ) . '</option>';
							}
							$output .= '</select>';
						} else {
								$output .= '<input name="user_registration_form_value[condition_' . $condition_id . '][' . $data_key . ']" value="' . esc_attr( $fields_data[2] ) . '" class="urcl-user-role-field" type="text" />';
						}
						$output .= '</div>';
						$output .= '<span class="add">';
						$output .= esc_html__( 'AND', 'user-registration-conditional-logic' );
						$output .= '</span>';
						$output .= '<span class="remove">';
						$output .= '<i class="dashicons dashicons-minus"></i>';
						$output .= '</span></li>';
						$data_key++;
					}
					$output .= '</ul>';
				}

				if ( isset( $conditions['or_conditions'] ) && isset( $conditions['or_conditions'] ) ) {
					foreach ( $conditions['or_conditions'] as $condition ) {
						$output .= '<p class="urcl-or-label">' . esc_html__( 'OR', 'user-registration-conditional-logic' ) . '</p>';
						$output .= '<ul class="urcl-or-groups urcl-role-logic-box" data-group ="condition_' . $condition_id . '" data-last-or-key="' . count( $conditions['or_conditions'] ) . '">';

						$data_key = 1;

						foreach ( $condition as $condition_field ) {
							$output .= '<li class="urcl-conditional-or-group" data-key="' . $data_key . '">';
							$output .= '<div class="urcl-form-group">';

							$fields_data = wp_list_pluck( $condition_field, 'field_value' );

							$output .= '<select class="urcl-user-role-field urcl-field-conditional-field-select" name="user_registration_form_fields[condition_' . $condition_id . '][' . $data_key . ']">';
							$output .= '<option value="">' . esc_html__( '-- Select --', 'user-registration-conditional-logic' ) . '</option>';

							$selected_urcl_field_type = '';
							$selected_urcl_field_key  = '';

							foreach ( $get_all_fields as $ind_field_key => $ind_field_value ) {
								$selectedField = $fields_data[0] == $ind_field_key ? 'selected="selected"' : '';

								if ( $fields_data[0] == $ind_field_key ) {
									$selected_urcl_field_type = $ind_field_value['field_key'];
									$selected_urcl_field_key  = $ind_field_key;
								}
								$output .= '<option value="' . esc_attr__( $ind_field_key, 'user-registration-conditional-logic' ) . '" data-type="' . esc_attr__( $ind_field_value['field_key'], 'user-registration-conditional-logic' ) . '" ' . $selectedField . '> ' . $ind_field_value['label'] . ' </option>';
							}
							$output .= '</select></div>';
							$output .= '<div class="urcl-operator"><select class="urcl-user-role-field" name="user_registration_form_operator[condition_' . $condition_id . '][' . $data_key . ']">';
							$output .= '<option value = "is"  ' . ( 'is' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'is', 'user-registration-conditional-logic' ) . ' </option>';
							$output .= '<option value = "is_not" ' . ( 'is_not' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'is not', 'user-registration-conditional-logic' ) . ' </option>';
							$output .= '<option value = "empty" ' . ( 'empty' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'empty', 'user-registration-conditional-logic' ) . ' </option>';
							$output .= '<option value = "not_empty" ' . ( 'not_empty' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'not empty', 'user-registration-conditional-logic' ) . ' </option>';
							$output .= '<option value = "greater_than" ' . ( 'greater_than' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'greater than', 'user-registration-conditional-logic' ) . ' </option>';
							$output .= '<option value = "less_than" ' . ( 'less_than' === $fields_data[1] ? 'selected' : '' ) . '> ' . esc_html__( 'less than', 'user-registration-conditional-logic' ) . ' </option>';
							$output .= '</select></div>';
							$output .= '<div class="urcl-value">';

							if ( $selected_urcl_field_type == 'checkbox' || $selected_urcl_field_type == 'radio' || $selected_urcl_field_type == 'select' || $selected_urcl_field_type == 'country' || $selected_urcl_field_type == 'billing_country' || $selected_urcl_field_type == 'shipping_country' ) {
								$choices = get_checkbox_choices( $form_id, $selected_urcl_field_key );
								$output .= '<select name="user_registration_form_value[condition_' . $condition_id . '][' . $data_key . ']" class="urcl-user-role-field">';

								if ( is_array( $choices ) && array_filter( $choices ) ) {
									$output .= '<option>--select--</option>';
									foreach ( $choices as $key => $choice ) {
										$key           = $selected_urcl_field_type == 'country' ? $key : $choice;
										$selectedvalue = $fields_data[2] == $key ? 'selected="selected"' : '';
										$output       .= '<option ' . $selectedvalue . ' value="' . $key . '">' . esc_html( $choice ) . '</option>';
									}
								} else {
									$selected = isset( $fields_data[2] ) ? $fields_data[2] : 0;
									$output  .= '<option value="1" ' . ( $selected == '1' ? 'selected="selected"' : '' ) . ' >' . __( 'Checked', 'user-registration-conditional-logic' ) . '</option>';
								}
								$output .= '</select>';
							} else {
									$output .= '<input name="user_registration_form_value[condition_' . $condition_id . '][' . $data_key . ']" value="' . esc_attr( $fields_data[2] ) . '" class="urcl-user-role-field" type="text" />';
							}
							$output .= '</div>';
							$output .= '<span class="add">';
							$output .= esc_html__( 'AND', 'user-registration-conditional-logic' );
							$output .= '</span>';
							$output .= '<span class="remove">';
							$output .= '<i class="dashicons dashicons-minus"></i>';
							$output .= '</span></li>';
							$data_key++;
						}
						$output .= '</ul>';
					}
				}
				$output .= '<button class="button button-secondary button-medium urcl-add-or-condition">Add OR Condition</button>';

				if ( count( $condition_role_settings ) > 1 ) {
					$output .= '<button class="urcl-remove-condition"></button>';
				}
				$output .= '</div>';
				$condition_id++;
			}
			$output .= '</div>';
			$output .= '<button class="button button-secondary button-medium urcl-add-new-condition" data-last-conditionid="' . $condition_id . '">Add New Condition</button></div>';
			return $output;
		}
	}

	/**
	 * Conditional Field Blocks
	 *
	 * @param string $id Field Id
	 * @param mixed  $admin_data Admin Data
	 */
	public function conditional_field( $id, $admin_data ) {

		$conditional_settings = $this->get_field_conditional_settings( $id, $admin_data );

		if ( '' != $conditional_settings ) {

			echo "<div class='ur-advance-setting-block'>";

			echo '<h2 class="ur-toggle-heading">' . __( 'Conditional Settings', 'user-registration-conditional-logic' ) . '</h2>';

			echo '<hr>';

				echo '<div class="ur-toggle-content">';

				echo $conditional_settings;

				echo '</div>';

			echo '</div>';
		}
	}

	/**
	 * Get field conditional settings.
	 *
	 * @param string $id
	 * @param mixed  $admin_data
	 */
	public function get_field_conditional_settings( $id, $admin_data ) {

		$file_name = str_replace( 'user_registration_', '', $id );

		$file_path = URCL_FORM_PATH . 'conditional-settings' . URCL_DS . 'class-ur-conditional-setting-' . strtolower( $file_name ) . '.php';

		$class_name = 'URCL_Conditional_Setting_' . ucwords( $file_name );

		if ( class_exists( $class_name ) ) {
			$instance = new $class_name();
			return $instance->output( $admin_data );
		}

		return '';
	}

	/**
	 * Save Conditional User Role settings.
	 *
	 * @return void.
	 */
	public function save_conditional_role_settings( $post ) {
		$form_id                 = absint( $post['form_id'] );
		$condition_role_settings = isset( $post['conditional_roles_settings_data'] ) ? wp_unslash( $post['conditional_roles_settings_data'] ) : array();

		// conditional user role settings save.
		if ( ! empty( $condition_role_settings ) ) {
				update_post_meta( $form_id, 'user_registration_user_role_condition', $condition_role_settings );
		}
	}

	/**
	 * Conditionally assign user role.
	 *
	 * @param  array $setting
	 * @return array $setting
	 */
	public function urcl_admin_conditional_role_setting( $setting ) {

		$form_id      = isset( $_GET['edit-registration'] ) ? absint( $_GET['edit-registration'] ) : 0;
		$form_setting = array(
			array(
				'type'              => 'checkbox',
				'label'             => __( 'Enable Assign User Role Conditionally', 'user-registration-conditional-logic' ),
				'description'       => '',
				'required'          => false,
				'id'                => 'user_registration_form_setting_enable_assign_user_role_conditionally',
				'class'             => array( 'ur-enhanced-select', 'urcl-form-settings-enable-assign-user-role' ),
				'input_class'       => array(),
				'custom_attributes' => array(),
				'default'           => ur_get_single_post_meta( $form_id, 'user_registration_form_setting_enable_assign_user_role_conditionally', 'no' ),
				'tip'               => __( 'Assign certain role only if your conditions are met.', 'user-registration-conditional-logic' ),
			),
		);

		$setting['setting_data'] = array_merge( $setting['setting_data'], $form_setting );
		return $setting;
	}
}

new URCL_Conditional_field();
