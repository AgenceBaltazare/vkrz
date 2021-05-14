<?php
/**
 * UserRegistrationConditional Logic Frontend
 *
 * @author   WPEverest
 * @category Core
 * @package  UserRegistrationConditionalLogic/Frontend
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * URCL_Frontend Class
 */

class URCL_Frontend {

	public function __construct() {
		add_action( 'user_registration_enqueue_scripts', array( $this, 'frontend_scripts' ), 10, 2 );
		add_action( 'user_registration_my_account_enqueue_scripts', array( $this, 'frontend_scripts' ), 10, 2 );
		add_action( 'init', array( $this, 'conditional_rules_include' ) );

		// Assign User Role Conditionally while after user registration.
		add_action( 'user_registration_after_register_user_action', array( $this, 'assign_user_role_conditionally' ), 10, 3 );
	}

	/**
	 * Assign User Role Conditionally while after user registration.
	 *
	 * @param array $user_data
	 * @param int   $form_id
	 * @param int   $user_id
	 * @return void
	 */
	public function assign_user_role_conditionally( $user_data, $form_id, $user_id ) {
		global $table_prefix;
		$condition_role_settings = get_post_meta( $form_id, 'user_registration_user_role_condition', true );

		if ( ! empty( $condition_role_settings ) ) {

			$assign_roles_list = array();

			// Extract conditional rules groups.
			foreach ( $condition_role_settings as $conditions ) {
				$assign_role  = $conditions['assign_role'];
				$flag         = false;
				$group_status = true;

				// Extract conditional AND groups.
				foreach ( $conditions['conditions'] as $group ) {
					$fields_data = wp_list_pluck( $group, 'field_value' );

					// Comparing condition with logic gates.
					$flag = $this->verify_user_role_conditions( $user_data, $fields_data );

					if ( false === $flag ) {
						$group_status = false;
					}
				}

				/**
				 * Check above conditions true or false,
				 * if all conditions are true then assign specific role and exit from the loop else continue with OR conditions.
				 * if OR condition not set then continue loop with next conditional rule group.
				 */
				if ( true === $group_status ) {
					array_push( $assign_roles_list, $assign_role );
				} elseif ( isset( $conditions['or_conditions'] ) ) {
					$group_or_status = true;

					// Extract conditional OR groups.
					foreach ( $conditions['or_conditions'] as $groups ) {

						$and_status = true;
						foreach ( $groups as $individual_group ) {
							$fields_data = wp_list_pluck( $individual_group, 'field_value' );

							// Comparing condition with logic gates.
							$flag = $this->verify_user_role_conditions( $user_data, $fields_data );

							if ( false === $flag ) {
								$and_status = false;
								break;
							}
						}

						if ( ! $and_status ) {
							$group_or_status = false;
						} else {
							$group_or_status = true;
							break;
						}
					}

					/**
					 * Check above OR conditions true or false,
					 * if all conditions are true then assign specific role and exit from the loop else continue with OR conditions.
					 */
					if ( true === $group_or_status ) {
						array_push( $assign_roles_list, $assign_role );
					}
				}
			}

			if ( ! empty( $assign_roles_list ) ) {

				// Re-ordering roles according to priority.
				$user_roles_list = ur_get_default_admin_roles();

				foreach ( $user_roles_list as $key => $value ) {

					if ( ! in_array( $key, $assign_roles_list, true ) ) {
						unset( $user_roles_list[ $key ] );
					} else {
						$user_roles_list[ $key ] = true;
					}
				}
				$field_name = $table_prefix . 'capabilities';
				update_user_meta( $user_id, $field_name, $user_roles_list );
			}
		}
	}

	/**
	 * Comparing condition with user-data and conditional field data.
	 *
	 * @param array $user_data
	 * @param array $fields_data
	 *
	 * @return boolean
	 */
	public function verify_user_role_conditions( $user_data, $fields_data ) {
		$rule_field    = $fields_data[0];
		$rule_operator = $fields_data[1];
		$rule_value    = $fields_data[2];
		$pass_rule     = false;

		if ( empty( $rule_field ) ) {
			return $pass_rule;
		}
		$form_field = $user_data[ $rule_field ];

		$right = trim( strtolower( $rule_value ) );

		if ( isset( $form_field->value ) ) {

			if ( is_array( $form_field->value ) ) {

				foreach ( $form_field->value as $value ) {
					$left = trim( strtolower( $value ) );
					// Using logic gates to compare left and right values.
					$pass_rule = $this->logic_gates( $left, $right, $rule_operator );

					if ( $pass_rule ) {
						break;
					}
				}
			} else {
				$left = trim( strtolower( $form_field->value ) );
				// Using logic gates to compare left and right values.
				$pass_rule = $this->logic_gates( $left, $right, $rule_operator );
			}
		}

		return $pass_rule;
	}

	/**
	 * Logic gates to compare left and right values.
	 *
	 * @param string $left
	 * @param string $right
	 * @param string $rule_operator
	 *
	 * @return boolean
	 */
	public function logic_gates( $left, $right, $rule_operator ) {
		$pass_rule = false;
		switch ( $rule_operator ) {
			case 'is':
				$pass_rule = ( $left == $right );
				break;
			case 'is_not':
				$pass_rule = ( $left != $right );
				break;
			case 'empty':
				$pass_rule = ( '' == $left );
				break;
			case 'not_empty':
				$pass_rule = ( '' != $left );
				break;
			case 'greater_than':
				$left      = preg_replace( '/[^0-9.]/', '', $left );
				$pass_rule = ( '' !== $left ) && ( floatval( $left ) > floatval( $right ) );
				break;
			case 'less_than':
				$left      = preg_replace( '/[^0-9.]/', '', $left );
				$pass_rule = ( '' !== $left ) && ( floatval( $left ) < floatval( $right ) );
				break;
		}
		return $pass_rule;
	}

	public function conditional_rules_include() {
		$fields = ur_get_registered_form_fields();
		$fields = function_exists( 'user_registration_payment_fields' ) ? array_merge( $fields, user_registration_payment_fields() ) : $fields;

		foreach ( $fields as $field ) {
			add_filter( 'user_registration_' . $field . '_frontend_form_data', array( $this, 'include_conditions' ) );
		}
	}

	// Include necessary frontend scripts
	public function frontend_scripts( $form_data_array, $form_id ) {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'urcl-frontend-script', URCL()->plugin_url() . '/assets/js/frontend/urcl-frontend' . $suffix . '.js' );
		wp_enqueue_style( 'urcl-frontend-style', URCL()->plugin_url() . '/assets/css/urcl-frontend.css' );
	}

	// Include conditions for fields if any
	public function include_conditions( $filter_data ) {

		$enable_conditional_logic = isset( $filter_data['data']['advance_setting']->enable_conditional_logic ) ? $filter_data['data']['advance_setting']->enable_conditional_logic : '';

		if ( $enable_conditional_logic != '1' ) {
			return $filter_data;
		}
		// get this field id
		$id = isset( $filter_data['data']['general_setting']->field_name ) ? $filter_data['data']['general_setting']->field_name : '';

		// Show/hide
		$conditional_rules = isset( $filter_data['data']['advance_setting']->conditional_rules ) ? $filter_data['data']['advance_setting']->conditional_rules : '';

		// Any/All
		$logic_gate = isset( $filter_data['data']['advance_setting']->logic_gate ) ? $filter_data['data']['advance_setting']->logic_gate : '';

		// Get all advance data
		$advance_data = $filter_data['data']['advance_setting'];

		// convert to array
		$array = (array) $advance_data;

		// and then wrap all rules into an array
		foreach ( $array as $key => $value ) {

			$bits = explode( '_', $key );
			if ( isset( $bits[2] ) && is_numeric( $bits[2] ) ) {
				$newdata[ $bits[0] ][ $bits[2] - 1 ][ $bits[1] ] = $value;
			}
		}

		$old_rules = isset( $newdata['rules'] ) ? $newdata['rules'] : array();

		// Create new array and then push into empty array to avoid indexing conflicts
		$rules = array();
		foreach ( $old_rules as $old_rule ) {
			array_push( $rules, $old_rule );
		}

		// Assign rules to frontend data
		$filter_data['form_data']['enable_conditional_logic'] = $enable_conditional_logic;
		$filter_data['form_data']['conditional_rules']        = $conditional_rules;
		$filter_data['form_data']['logic_gate']               = $logic_gate;
		$filter_data['form_data']['rules']                    = $rules;

		// assign this field id
		$filter_data['form_data']['id'] = $id;

		// get required index
		$is_required = isset( $filter_data['form_data']['required'] ) ? $filter_data['form_data']['required'] : '0';

		 // If show is the conditional rule
		if ( isset( $filter_data['form_data']['conditional_rules'] ) && $filter_data['form_data']['conditional_rules'] == '0' ) {
			// Add class to if show only on condition
			array_push( $filter_data['form_data']['input_class'], 'urcl-hide-field' );
		}
		return $filter_data;
	}
}
new URCL_Frontend();
