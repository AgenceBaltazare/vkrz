<?php

namespace ACA\ACF\Field;

use AC;
use ACA\ACF\Editing;
use ACA\ACF\Field;
use ACA\ACF\Filtering;
use ACA\ACF\Sorting;
use ACP;

class Wysiwyg extends Field {

	public function get_dependent_settings() {
		return array(
			new AC\Settings\Column\WordLimit( $this->column ),
		);
	}

	public function editing() {
		return new Editing\Textarea( $this->column );
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