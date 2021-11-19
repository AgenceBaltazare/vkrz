<?php

namespace ACA\ACF\Editing;

use ACA\ACF\Column;
use ACA\ACF\Editing;

class Wysiwyg extends Editing {

	/**
	 * @var string
	 */
	private $editable_type;

	public function __construct( Column $column, $editable_type = null ) {
		$this->editable_type = $editable_type ?: 'textarea';

		parent::__construct( $column );
	}

	public function get_view_settings() {
		$data = parent::get_view_settings();
		$data['type'] = $this->editable_type;

		return $data;
	}

}