<?php

namespace ACA\ACF\Field;

use ACA\ACF\Editing;
use ACA\ACF\Filtering;

class Relationship extends PostObject {

	public function __construct( $column ) {
		parent::__construct( $column );

		$this->column->set_serialized( true );
	}

	public function editing() {
		return new Editing\PostObjects( $this->column );
	}

	public function filtering() {
		return new Filtering\PostObject( $this->column );
	}

}