<?php

namespace ACA\ACF\Editing;

use ACP\Editing\View\AjaxSelect;

class PostObjects extends PostObject {

	public function get_view( $context ) {
		$view = new AjaxSelect();
		$view->set_multiple( true )
		     ->set_revisioning( false );

		if ( $this->column->get_field()->get( 'allow_null' ) ) {
			$view->set_clear_button( true );
		}

		if ( $context === self::CONTEXT_BULK ) {
			$view->has_methods( true );
		}

		return $view;
	}

	public function save( $id, $value ) {
		if ( ! isset( $value['method'] ) ) {
			return parent::save( $id, $value );
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

	private function extend_value( $id, $values ) {
		$old_values = array_keys( $this->get_edit_value( $id ) );
		$new_values = array_merge( $old_values, $values );

		return array_unique( $new_values );
	}

	private function reduce_value( $id, $remove_values ) {
		$values = array_keys( $this->get_edit_value( $id ) );

		foreach ( $values as $key => $value ) {
			if ( in_array( $value, $remove_values ) ) {
				unset( $values[ $key ] );
			}
		}

		return $values;
	}

}