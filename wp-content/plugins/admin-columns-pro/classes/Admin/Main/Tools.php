<?php

namespace ACP\Admin\Main;

use AC\Asset;
use AC\Asset\Location;
use AC\Renderable;
use AC\View;
use ACP;

class Tools implements Asset\Enqueueables, Renderable {

	const NAME = 'import-export';

	/**
	 * @var Renderable[]
	 */
	private $sections = [];

	/**
	 * @var Location\Absolute
	 */
	private $location;

	public function __construct( Location\Absolute $location ) {
		$this->location = $location;
	}

	/**
	 * @param Renderable $section
	 *
	 * @return $this
	 */
	public function add_section( Renderable $section ) {
		$this->sections[] = $section;

		return $this;
	}

	public function get_assets() {
		$assets = new Asset\Assets( [
			new Asset\Style( 'acp-style-tools', $this->location->with_suffix( 'assets/core/css/admin-tools.css' ) ),
			new Asset\Script( 'acp-script-tools', $this->location->with_suffix( 'assets/core/js/tools.js' ) ),
		] );

		foreach ( $this->sections as $section ) {
			if ( $section instanceof Asset\Enqueueables ) {
				$assets->add_collection( $section->get_assets() );
			}
		}

		return $assets;
	}

	public function render() {
		$view = new View( [
			'sections' => $this->sections,
		] );

		$view->set_template( 'admin/page/tools' );

		return $view->render();
	}

}