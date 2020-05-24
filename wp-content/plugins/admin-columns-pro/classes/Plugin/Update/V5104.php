<?php

namespace ACP\Plugin\Update;

use AC\ListScreenRepository\Database;
use AC\ListScreenTypes;
use AC\Plugin\Update;

class V5104 extends Update {

	public function apply_update() {
		$this->set_default_export_option();
	}

	protected function set_version() {
		$this->version = '5.1.4';
	}

	private function set_default_export_option() {
		$repo = new Database( ListScreenTypes::instance() );

		foreach ( $repo->find_all() as $list_screen ) {
			$settings = $list_screen->get_settings();

			$updated = false;

			foreach ( $settings as $column_name => $setting ) {
				if ( ! isset( $setting['export'] ) ) {
					$settings[ $column_name ]['export'] = 'on';

					$updated = true;
				}
			}

			if ( $updated ) {
				$list_screen->set_settings( $settings );

				$repo->save( $list_screen );
			}
		}
	}

}