<?php

namespace ACP\Sorting\Model\Post;

use ACP\Sorting\Model;

class ImageFileSizes extends Model {

	public function get_sorting_vars() {
		$this->set_data_type( 'numeric' );

		$ids = [];

		foreach ( $this->strategy->get_results() as $id ) {
			$ids[ $id ] = array_sum( $this->column->get_raw_value( $id ) );
		}

		return [
			'ids' => $this->sort( $ids ),
		];
	}

}