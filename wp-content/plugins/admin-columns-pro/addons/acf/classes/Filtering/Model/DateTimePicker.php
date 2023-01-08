<?php

namespace ACA\ACF\Filtering\Model;

use ACP;

class DateTimePicker extends ACP\Filtering\Model\MetaDate {

	public function __construct( $column ) {
		parent::__construct( $column );

		$this->set_date_format( 'Y-m-d H:i:s' );
	}

}