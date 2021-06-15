<?php

namespace ACP\Column\User;

use AC;
use ACP\Export;
use ACP\Sorting;

/**
 * @since 4.0
 */
class PostCount extends AC\Column\User\PostCount
	implements Sorting\Sortable, Export\Exportable {

	public function sorting() {
		return new Sorting\Model\User\PostCount( $this->get_post_types(), $this->get_selected_post_status() );
	}

	public function export() {
		return new Export\Model\StrippedValue( $this );
	}

	/**
	 * @return array
	 */
	private function get_post_types() {
		$post_type = $this->get_selected_post_type();

		if ( 'any' === $post_type ) {
			$post_type = get_post_types();
		}

		return (array) $post_type;
	}

}