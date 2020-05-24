<?php

namespace ACP\Search\Settings;

use AC;
use AC\View;
use ACP;

class Column extends AC\Settings\Column {

	/**
	 * @return array
	 */
	protected function define_options() {
		return [
			'search',
		];
	}

	private function get_instructions() {
		$view = new View();
		$view->set_template( 'tooltip/smart-filtering' );

		return $view->render();
	}

	/**
	 * @return View
	 */
	public function create_view() {
		$view = new View();
		$view->set( 'label', __( 'Smart Filtering', 'codepress-admin-columns' ) )
		     ->set( 'instructions', $this->get_instructions() )
		     ->set( 'setting',
			     sprintf( '<em>%s</em>', __( 'Enabled', 'codepress-admin-columns' ) )
		     );

		return $view;
	}

	/**
	 * @return bool True when search is selected
	 */
	public function is_active() {
		return apply_filters( 'acp/search/smart-filtering-active', true, $this );
	}

}