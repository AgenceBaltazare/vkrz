<?php

namespace ACA\ACF\Field;

use ACA\ACF\Editing;
use ACA\ACF\Field;
use ACA\ACF\Filtering;
use ACP;
use AC;

class Number extends Field {

	public function get_dependent_settings() {
		$settings = parent::get_dependent_settings();
		$settings[] = new AC\Settings\Column\NumberFormat( $this->column );

		return $settings;
	}

	public function editing() {
		return new Editing\Number( $this->column );
	}

	public function sorting() {
		$model = new ACP\Sorting\Model\Meta( $this->column );
		$model->set_data_type( 'numeric' );

		return $model;
	}

	public function filtering() {
		return new Filtering\Number( $this->column );
	}

	public function search() {
		return new ACP\Search\Comparison\Meta\Numeric( $this->get_meta_key(), $this->get_meta_type() );
	}

}