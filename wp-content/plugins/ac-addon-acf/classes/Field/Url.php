<?php

namespace ACA\ACF\Field;

use ACA\ACF\Editing;
use ACA\ACF\Field;
use ACA\ACF\Filtering;
use ACA\ACF\Sorting;
use ACP;

class Url extends Field {

	public function get_value( $id ) {
		$url = parent::get_value( $id );

		return ac_helper()->html->link( $url, str_replace( array( 'http://', 'https://' ), '', $url ) );
	}

	public function editing() {
		return new Editing\Url( $this->column );
	}

	public function filtering() {
		return new Filtering( $this->column );
	}

	public function sorting() {
		return new Sorting( $this->column );
	}

	public function search() {
		return new ACP\Search\Comparison\Meta\Text( $this->get_meta_key(), $this->get_meta_type() );
	}

}