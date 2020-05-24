<?php

namespace ACA\ACF\Field;

use ACA\ACF\Column;
use ACA\ACF\Editing;
use ACA\ACF\Filtering;
use ACA\ACF\Search;

/**
 * @property Column $column
 */
class Checkbox extends Select {

	public function __construct( $column ) {
		parent::__construct( $column );

		$this->column->set_serialized( true );
	}

	public function editing() {
		return new Editing\Checkbox( $this->column );
	}

	public function filtering() {
		return new Filtering\Checkbox( $this->column );
	}

	public function search() {
		return new Search\MultiSelect( $this->get_meta_key(), $this->get_meta_type(), $this->get_choices() );
	}

}