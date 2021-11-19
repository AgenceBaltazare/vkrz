<?php

namespace ACA\ACF;

use AC;
use ACA\ACF\Field\Wysiwyg;
use ACP;

/**
 * @property Column $column
 */
class ColumnEditingSettingSetter {

	public function register( AC\Column $column ) {
		if ( ! $column instanceof Column ) {
			return;
		}

		$edit = $column->get_setting( 'edit' );

		if ( ! $edit instanceof ACP\Editing\Settings ) {
			return;
		}

		$section = $this->create_section( $column );

		if ( $section ) {
			$section->set_values( $column->get_options() );
			$edit->add_section( $section );
		}
	}

	/**
	 * @param $column
	 *
	 * @return AC\Settings\Column;
	 */
	private function create_section( $column ) {
		$field = $column->get_field();

		switch ( true ) {
			case $field instanceof Wysiwyg:
				return new ACP\Editing\Settings\EditableType\Content( $column );
			default:
				return null;
		}
	}

}