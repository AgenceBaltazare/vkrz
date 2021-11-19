<?php

namespace ACA\ACF\Editing;

class Taxonomies extends Taxonomy {

	public function get_view( $context ) {
		$view = parent::get_view( $context );
		$view->set_multiple( true );

		if ( $context === self::CONTEXT_BULK ) {
			$view->has_methods( true )
			     ->set_ajax_populate( false );
		}

		return $view;
	}

	/**
	 * @param $id
	 * @param $value
	 *
	 * @return bool
	 */
	public function save( $id, $value ) {
		if ( ! isset( $value['method'] ) ) {
			$value = [
				'method' => 'replace',
				'value'  => $value,
			];
		}

		switch ( $value['method'] ) {
			case 'add':
				return parent::save( $id, $this->extend_value( $id, $value['value'] ) );

			case 'remove':
				return parent::save( $id, $this->reduce_value( $id, $value['value'] ) );

			default:
				return parent::save( $id, $value['value'] );

		}

	}

	/**
	 * @param int   $id
	 * @param array $terms
	 *
	 * @return array
	 */
	private function extend_value( $id, $terms ) {
		$values = array_keys( $this->get_edit_value( $id ) );
		$new_values = array_merge( $values, $terms );

		return array_unique( $new_values );
	}

	/**
	 * @param int   $id
	 * @param array $terms
	 *
	 * @return array
	 */
	private function reduce_value( $id, $terms ) {
		$values = array_keys( $this->get_edit_value( $id ) );

		foreach ( $values as $key => $term ) {
			if ( in_array( $term, $terms ) ) {
				unset( $values[ $key ] );
			}
		}

		return $values;
	}

}