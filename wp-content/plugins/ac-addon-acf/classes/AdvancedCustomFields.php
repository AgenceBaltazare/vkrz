<?php

namespace ACA\ACF;

use AC;

final class AdvancedCustomFields extends AC\Plugin {

	public function __construct( $file ) {
		parent::__construct( $file, 'aca_acf' );
	}

	/**
	 * Register hooks
	 */
	public function register() {
		add_action( 'ac/column/settings', [ $this, 'register_editing_sections' ] );
		add_action( 'ac/column_groups', [ $this, 'register_column_groups' ] );
		add_action( 'ac/column_types', [ $this, 'add_columns' ] );
		add_action( 'ac/table_scripts/editing', [ $this, 'table_scripts_editing' ] );
		add_action( 'ac/admin_scripts/columns', [ $this, 'settings_scripts' ] );
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