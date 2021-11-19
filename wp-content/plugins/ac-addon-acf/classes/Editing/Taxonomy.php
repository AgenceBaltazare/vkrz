<?php

namespace ACA\ACF\Editing;

use AC;
use ACA\ACF\Editing;
use ACP;
use ACP\Editing\View\AjaxSelect;
use ACP\Helper\Select;
use ACP\Helper\Select\Formatter;

class Taxonomy extends Editing
	implements ACP\Editing\PaginatedOptions {

	public function get_view( $context ) {
		$view = new AjaxSelect();

		if ( $this->column->get_field()->get( 'allow_null' ) ) {
			$view->set_clear_button( true );
		}

		return $view;
	}

	public function get_view_settings() {
		$data = parent::get_view_settings();

		$data['type'] = 'acf_select2';
		$data['ajax_populate'] = true;
		$data['store_values'] = false;
		$data['disable_revisioning'] = false;
		$data['clear_button'] = empty( $data['required'] );

		switch ( $this->column->get_acf_field_option( 'field_type' ) ) {
			case 'checkbox' :
			case 'multi_select' :
				$data['multiple'] = true;
				break;
		}

		return $data;
	}

	/**
	 * @return array|string
	 */
	private function get_taxonomy() {
		return $this->column->get_acf_field_option( 'taxonomy' );
	}

	public function get_paginated_options( $search, $page, $id = null ) {
		$entities = new Select\Entities\Taxonomy( [
			'search'   => $search,
			'page'     => $page,
			'taxonomy' => $this->get_taxonomy(),
		] );

		return new AC\Helper\Select\Options\Paginated(
			$entities,
			new Formatter\TermName( $entities )
		);
	}

	/**
	 * @param int $term_id
	 *
	 * @return array
	 */
	public function get_edit_value( $term_id ) {
		$term_ids = parent::get_edit_value( $term_id );

		$taxonomy = $this->get_taxonomy();

		$values = [];
		foreach ( ac_helper()->taxonomy->get_terms_by_ids( $term_ids, $taxonomy ) as $term ) {
			$values[ $term->term_id ] = $term->name;
		}

		return $values;
	}

}