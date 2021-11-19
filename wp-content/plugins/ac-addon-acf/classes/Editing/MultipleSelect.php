<?php

namespace ACA\ACF\Editing;

use ACP\Editing\View\AdvancedSelect;

class MultipleSelect extends Options {

	public function get_view( $context ) {
		$view = new AdvancedSelect( $this->column->get_field()->get( 'choices' ) );
		$view->set_multiple( true )
		     ->set_clear_button( true );

		if ( $context === self::CONTEXT_BULK ) {
			$view->has_methods( true );
			$view->set_revisioning( false );
		}

		return $view;
	}

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
		$values = array_values( (array) $this->get_edit_value( $id ) );
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
		$values = array_values( (array) $this->get_edit_value( $id ) );

		foreach ( $values as $key => $term ) {
			if ( in_array( $term, $terms ) ) {
				unset( $values[ $key ] );
			}
		}

		return array_values( $values );
	}

}