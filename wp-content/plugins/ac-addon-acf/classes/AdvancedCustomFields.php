<?php

namespace ACA\ACF;

use AC;
use AC\Plugin;
use AC\Plugin\Version;
use AC\PluginInformation;
use AC\Registrable;

final class AdvancedCustomFields extends Plugin implements Registrable {

	public function __construct( $file, Version $version ) {
		parent::__construct( $file, $version );
	}

	public function register() {
		add_action( 'ac/column/settings', [ $this, 'register_editing_sections' ] );
		add_action( 'ac/column_groups', [ $this, 'register_column_groups' ] );
		add_action( 'ac/column_types', [ $this, 'add_columns' ] );
		add_action( 'ac/table_scripts/editing', [ $this, 'table_scripts_editing' ] );
		add_action( 'ac/admin_scripts/columns', [ $this, 'settings_scripts' ] );

		$plugin_information = new PluginInformation( $this->get_basename() );
		$is_network_active = $plugin_information->is_network_active();
		$setup_factory = new AC\Plugin\SetupFactory( 'aca_acf_version', $this->get_version() );

		$services[] = new AC\Service\Setup( $setup_factory->create( AC\Plugin\SetupFactory::SITE ) );

		if ( $is_network_active ) {
			$services[] = new AC\Service\Setup( $setup_factory->create( AC\Plugin\SetupFactory::NETWORK ) );
		}

		array_map( [ $this, 'register_service' ], $services );
	}

	private function register_service( Registrable $registrable ) {
		$registrable->register();
	}

	/**
	 * @param AC\Groups $groups
	 */
	public function register_column_groups( $groups ) {
		$groups->register_group( 'acf', __( 'Advanced Custom Fields' ), 11 );
	}

	/**
	 * Add custom columns
	 *
	 * @param AC\ListScreen $list_screen
	 *
	 * @since 1.0
	 */
	public function add_columns( $list_screen ) {
		$content_types = [ 'Post', 'Media', 'User', 'Comment', 'Taxonomy' ];

		foreach ( $content_types as $content_type ) {
			$instance = 'ACP\Listscreen\\' . $content_type;

			if ( $list_screen instanceof $instance ) {
				$column = 'ACA\ACF\Column\\' . $content_type;

				$list_screen->register_column_type( new $column );

				break;
			}
		}
	}

	public function table_scripts_editing() {
		$script = new AC\Asset\Script( 'ac-acf-table', $this->get_location()->with_suffix( 'assets/js/table.js' ), [ 'jquery' ] );
		$script->enqueue();

		$style = new AC\Asset\Style( 'ac-acf-table', $this->get_location()->with_suffix( 'assets/css/table.css' ) );
		$style->enqueue();
	}

	public function settings_scripts() {
		$script = new AC\Asset\Script( 'ac-acf-settings', $this->get_location()->with_suffix( 'assets/js/admin.js' ), [ 'jquery' ] );
		$script->enqueue();
	}

	public function register_editing_sections( AC\Column $column ) {
		( new ColumnEditingSettingSetter() )->register( $column );
	}

}