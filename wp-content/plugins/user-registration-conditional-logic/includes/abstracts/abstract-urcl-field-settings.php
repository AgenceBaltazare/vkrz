<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract URCL Field Setting Class
 *
 * @version  1.0.0
 * @package  UserRegistrationConditioanlLogic/Abstracts
 * @category Abstract Class
 * @author   WPEverest
 */
abstract class URCL_Field_Settings {

	public $field_id;

	public $fields_html;

	public $field_data = array();

	public $default_class = 'ur_advance_setting';

	/**
	 * Output conditional logic settings UI html.
	 *
	 * @param array $field_data Current field's data.
	 *
	 * @return string Conditional logic settings UI html.
	 */
	public function output( $field_data = array() ) {
		$this->field_data = self::migrate_to_logic_map_schema( $field_data );

		$this->prepare_ui_html( $field_data );

		return $this->fields_html;
	}

	/**
	 * Migrate a field's conditional logic data to logc_map schema.
	 *
	 * @param object|array $field_data
	 */
	public static function migrate_to_logic_map_schema( $field_data ) {
		$field_data = (object) $field_data;

		if ( isset( $field_data->advance_setting ) && ! isset( $field_data->advance_setting->cl_map ) && isset( $field_data->advance_setting->conditional_rules ) ) {
			$advance_setting = $field_data->advance_setting;
			$action          = isset( $advance_setting->conditional_rules ) && '0' === $advance_setting->conditional_rules ? 'show' : 'hide';
			$logic_gate      = isset( $advance_setting->logic_gate ) && '0' === $advance_setting->logic_gate ? 'OR' : 'AND';
			$conditions      = array();

			foreach ( $advance_setting as $key => $value ) {
				if ( strpos( $key, 'rules_field_' ) === 0 ) {
					preg_match( '/rules_field_(\d+)/', $key, $condition_id );

					$condition_id = isset( $condition_id[1] ) ? $condition_id[1] : null;

					if ( ! is_null( $condition_id ) ) {
						$operator_key    = 'rules_condition_' . $condition_id;
						$value_key       = 'rules_value_' . $condition_id;
						$operator        = isset( $advance_setting->$operator_key ) && '0' === $advance_setting->$operator_key ? 'is' : 'is_not';
						$condition_value = isset( $advance_setting->$value_key ) ? $advance_setting->$value_key : null;

						$conditions[] = array(
							'type'         => 'field',
							'triggerer_id' => $value,
							'operator'     => $operator,
							'value'        => $condition_value,
						);
					}
				}
			}
			$cl_map                              = array(
				'action'    => $action,
				'logic_map' => array(
					'type'       => 'group',
					'logic_gate' => $logic_gate,
					'conditions' => array(
						array(
							'type'       => 'group',
							'logic_gate' => $logic_gate,
							'conditions' => $conditions,
						),
					),
				),
			);
			$field_data->advance_setting->cl_map = json_encode( $cl_map );
		}
		return $field_data;
	}

	/**
	 * Prepare conditional logic settings UI html.
	 *
	 * @param array|object $field_data
	 */
	public function prepare_ui_html( $field_data ) {
		$enabled_status  = $this->get_advance_setting_data( 'enable_conditional_logic' );
		$enabled         = ( '1' === $enabled_status || 'on' === $enabled_status );
		$cl_map          = $this->get_advance_setting_data( 'cl_map', $this->get_initial_cl_map() );
		$tooltip_message = 'Enable/Disable conditional logic for this field.';
		$tooltip_html    = ur_help_tip( $tooltip_message, false, 'ur-portal-tooltip' );

		ob_start();
		echo '<div class="ur-advance-setting ur-advance-enable_conditional_logic">';
		echo '<label class="ur-label">';
		printf(
			'<input %s class="ur-enable-conditional-logic ur_advance_setting" data-advance-field="enable_conditional_logic" type="checkbox" class="input-checkbox">',
			$enabled ? 'checked="checked"' : ''
		);
		echo ' Enable Conditional Logic' . $tooltip_html . '</label>';
		echo '</div>';

		echo '<div class="ur-advance-setting ur-advance-cl_map" style="display:none;">';
		printf(
			'<input class="urcl-logic-map ur_advance_setting" data-advance-field="cl_map" value="%s" type="text">',
			esc_attr( $cl_map )
		);
		echo '</div>';

		printf(
			'<div class="urcl-conditional-logic urcl-logic-creator" %s>',
			$enabled ? '' : 'style="display:none;"'
		);

		echo '<label class="urcl-conditional-logic__label">Apply conditions</label>';

		echo '<div class="urcl-conditional-logic__ruleset urcl-action-container ur-d-flex ur-align-items-center ur-mb-1">';
		echo '<select class="urcl-conditional-logic__action urcl-action-input ur-form-field--sm ur-mr-1">';
		echo '<option value="show">Show</option>';
		echo '<option value="hide">Hide</option>';
		echo '</select>';
		echo 'if';
		echo '<select class="urcl-conditional-logic__option urcl-root-logic-gate ur-form-field--sm ur-mx-1">';
		echo '<option value="OR">Any</option>';
		echo '<option value="AND">All</option>';
		echo '</select>';
		echo 'of the following group matches';
		echo '</div>';

		echo '<div class="urcl-conditional-logic__group-wrap urcl-logic-map-container">';
		echo '</div>';

		echo '<div class="urcl-add-new-group-button-container">';
		echo '<button class="button button-tertiary urcl-add-new-group">New Group</button>';
		echo '</div>';

		echo '</div>';

		$this->fields_html = ob_get_clean();
	}

	/**
	 * Get a value of advance setting of the current field.
	 *
	 * @param string $key Key in the advance settings object.
	 * @param mixed  $default Value to return in case the specified key hasn't been set or is missing.
	 *
	 * @return mixed
	 */
	public function get_advance_setting_data( $key, $default = null ) {
		$field_data      = (object) $this->field_data;
		$advance_setting = isset( $field_data->advance_setting ) ? $field_data->advance_setting : null;

		if ( ! is_null( $advance_setting ) && isset( $advance_setting->$key ) ) {
			return $advance_setting->$key;
		}

		return $default;
	}

	/**
	 * Get initial state of a new conditional logic map.
	 */
	public function get_initial_cl_map() {
		$cl_map = array(
			'action'    => 'show',
			'logic_map' => array(
				'type'       => 'group',
				'logic_gate' => 'OR',
				'conditions' => array(
					array(
						'type'       => 'group',
						'logic_gate' => '',
						'conditions' => array(
							array(
								'type'         => 'field',
								'triggerer_id' => '',
								'operator'     => 'is',
								'value'        => '',
							),
						),
					),
				),
			),
		);
		return json_encode( $cl_map );
	}
}
