<?php

namespace ACA\ACF\Search;

use ACP\Helper\Select;
use ACP\Helper\Select\Formatter;
use ACP\Search\Comparison\Meta;
use ACP\Search\Comparison\SearchableValues;
use ACP\Search\Operators;

class Taxonomy extends Meta
	implements SearchableValues {

	/** @var string */
	private $taxonomy;

	public function __construct( $meta_key, $meta_type, $taxonomy ) {
		$operators = new Operators( array(
			Operators::EQ,
			Operators::NEQ,
			Operators::IS_EMPTY,
			Operators::NOT_IS_EMPTY,
		) );

		$this->taxonomy = $taxonomy;

		parent::__construct( $operators, $meta_key, $meta_type );
	}

	public function get_values( $search, $paged ) {
		$entities = new Select\Entities\Taxonomy( array(
			'page'     => $paged,
			'search'   => $search,
			'taxonomy' => $this->taxonomy,
		) );

		return new Select\Options\Paginated(
			$entities,
			new Formatter\TermName( $entities )
		);
	}

}