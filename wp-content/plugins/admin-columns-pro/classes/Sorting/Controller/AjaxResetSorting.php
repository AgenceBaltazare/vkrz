<?php

namespace ACP\Sorting\Controller;

use AC\Ajax;
use AC\ListScreenRepository\Storage;
use AC\Registrable;
use AC\Type\ListScreenId;
use ACP\Sorting\Table\Preference\SortedBy;

class AjaxResetSorting implements Registrable {

	/**
	 * @var Storage
	 */
	private $storage;

	public function __construct( Storage $storage ) {
		$this->storage = $storage;
	}

	public function register() {
		$this->get_ajax_handler()->register();
	}

	private function get_ajax_handler() {
		$handler = new Ajax\Handler();
		$handler
			->set_action( 'acp_reset_sorting' )
			->set_callback( [ $this, 'handle_reset' ] );

		return $handler;
	}

	public function handle_reset() {
		$this->get_ajax_handler()->verify_request();

		$list_screen = $this->storage->find( new ListScreenId( filter_input( INPUT_POST, 'layout' ) ) );

		if ( ! $list_screen ) {
			wp_die();
		}

		$preference = new SortedBy( $list_screen->get_storage_key() );

		wp_send_json_success( $preference->delete() );
	}

}