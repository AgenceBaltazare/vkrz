<?php

namespace ACA\ACF\Search;

use ACP\Search\Helper\MetaQuery\SerializedComparisonFactory;
use ACP\Search\Operators;
use ACP\Search\Value;

class Users extends User {

	protected function get_meta_query( $operator, Value $value ) {
		if ( Operators::CURRENT_USER === $operator ) {
			$value = new Value(
				(string) get_current_user_id(),
				$value->get_type()
			);
		}

		$comparison = SerializedComparisonFactory::create(
			$this->get_meta_key(),
			$operator,
			$value
		);

		return $comparison();
	}

}