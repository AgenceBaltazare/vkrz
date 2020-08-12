<?php

namespace ACP\Column\User;

use AC;
use ACP\Editing;
use ACP\Search;
use ACP\Sorting;

/**
 * @since 2.0
 */
class Description extends AC\Column\User\Description
	implements Sorting\Sortable, Search\Searchable, Editing\Editable {

	public function sorting() {
		return new Sorting\Model\User\Meta( $this->get_meta_key() );
	}

	public function editing() {
		return new Editing\Model\User\Description( $this );
	}

	public function search() {
		return new Search\Comparison\Meta\Text( $this->get_meta_key(), $this->get_meta_type() );
	}

}