<?php

namespace ACA\ACF\Field;

use AC\Settings\Column\NumberOfItems;
use ACA\ACF\Editing;
use ACA\ACF\Export;
use ACA\ACF\Field;
use ACA\ACF\Filtering;
use ACA\ACF\Search;
use ACP;

class Select extends Field {

	public function get_value( $id ) {
		$value = parent::get_value( $id );
		$choices = $this->get_choices();

		$options = array();
		foreach ( (array) $value as $value ) {
			if ( isset( $choices[ $value ] ) ) {
				$options[] = $choices[ $value ];
			}
		}

		$setting_limit = $this->column->get_setting( 'number_of_items' );

		return ac_helper()->html->more( $options, $setting_limit ? $setting_limit->get_value() : false );
	}

	public function get_dependent_settings() {
		if ( ! $this->column->get_field()->get( 'multiple' ) ) {
			return array();
		}

		return array(
			new NumberOfItems( $this->column ),
		);
	}

	public function editing() {
		if ( $this->column->get_field()->get( 'multiple' ) ) {
			return new Editing\MultipleSelect( $this->column );
		}

		return new Editing\Select( $this->column );
	}

	public function filtering() {
		return new Filtering\Options( $this->column );
	}

	public function sorting() {
		return new ACP\Sorting\Model\Meta( $this->column );
	}

	public function search() {
		if ( $this->is_serialized() ) {
			return new Search\MultiSelect( $this->get_meta_key(), $this->get_meta_type(), $this->get_choices() );
		}

		return new Search\Select( $this->get_meta_key(), $this->get_meta_type(), $this->get_choices() );
	}

	public function export() {
		return new Export\Select( $this->column );
	}

	protected function get_choices() {
		return $this->column->get_acf_field_option( 'choices' );
	}

}