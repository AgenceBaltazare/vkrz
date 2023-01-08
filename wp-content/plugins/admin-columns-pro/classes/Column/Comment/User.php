<?php

namespace ACP\Column\Comment;

use AC;
use ACP\ConditionalFormat;
use ACP\Editing;
use ACP\Export;
use ACP\Filtering;
use ACP\Search;
use ACP\Settings;
use ACP\Sorting;

/**
 * @since 4.0
 */
class User extends AC\Column\Comment\User
	implements Editing\Editable, Filtering\Filterable, Sorting\Sortable, Export\Exportable, Search\Searchable, ConditionalFormat\Formattable {

	use ConditionalFormat\ConditionalFormatTrait;

	public function sorting() {
		return ( new Sorting\Model\Comment\AuthorFactory() )->create( $this->get_setting( Settings\Column\User::NAME )->get_value(), $this );
	}

	public function editing() {
		return new Editing\Service\Comment\User();
	}

	public function filtering() {
		return new Filtering\Model\Comment\User( $this );
	}

	public function export() {
		return new Export\Model\StrippedValue( $this );
	}

	public function search() {
		return new Search\Comparison\Comment\User();
	}

}