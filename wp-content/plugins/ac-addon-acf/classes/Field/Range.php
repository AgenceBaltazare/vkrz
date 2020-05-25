<?php

namespace ACA\ACF\Field;

use ACA\ACF\Editing;
use ACA\ACF\Field;
use ACA\ACF\Filtering;
use ACP;

class Range extends Field {

	public function editing() {
		return new Editing\Range( $this->column );
	}

	public function sorting() {
		$model = new ACP\Sorting\Model\Meta( $this->column );

		return $model->set_data_type( 'numeric' );
	}

	public function filtering() {
		return new Filtering\Number( $this->column );
	}

	public function search() {
		return new ACP\Search\Comparison\Meta\Numeric( $this->get_meta_key(), $this->get_meta_type() );
	}

}