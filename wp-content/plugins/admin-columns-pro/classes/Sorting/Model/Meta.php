<?php

namespace ACP\Sorting\Model;

use AC;
use ACP;

/**
 * @property AC\Column\Meta $column
 */
class Meta extends ACP\Sorting\Model {

	public function __construct( AC\Column\Meta $column ) {
		parent::__construct( $column );
	}

	/**
	 * Get args for a WP_Meta_Query to sort on a single key
	 * @return array Arguments to sort with using a WP_Meta_Query
	 * @since 4.0
	 * @see   \WP_Meta_Query
	 */
	public function get_sorting_vars() {
		$key = $this->column->get_meta_key();
		$id = uniqid();
		$vars = [
			'meta_query' => [
				$id => [
					'key'     => $key,
					'type'    => $this->get_data_type(),
					'value'   => '',
					'compare' => '!=',
				],
			],
			'orderby'    => $id,
		];

		if ( acp_sorting_show_all_results() ) {
			$vars['meta_query'] = [
				'relation' => 'OR',

				// $id indicates which $key should be used for sorting. wp_query will use the $key for sorting, and applies both
				// the EXISTS and NOT EXISTS compares. Without $id it will not work when sorting is used
				// in conjunction with filtering.
				$id        => [
					'key'     => $key,
					'type'    => $this->get_data_type(),
					'compare' => 'EXISTS',
				],
				[
					'key'     => $key,
					'compare' => 'NOT EXISTS',
				],
			];
		}

		return $vars;
	}

}