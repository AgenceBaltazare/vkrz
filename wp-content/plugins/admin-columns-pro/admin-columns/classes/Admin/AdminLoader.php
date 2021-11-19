<?php

namespace AC\Admin;

use AC\Asset\Enqueueable;
use AC\Asset\Enqueueables;
use AC\Registrable;
use AC\Renderable;
use AC\Request;
use AC\View;

class AdminLoader implements Registrable {

	/**
	 * @var string
	 */
	protected $hook;

	/**
	 * @var RequestHandlerInterface
	 */
	protected $request_handler;

	/**
	 * @var Enqueueables
	 */
	protected $assets;

	/**
	 * @var Renderable|null
	 */
	private $page;

	public function __construct( $hook, RequestHandlerInterface $request_handler, Enqueueables $assets ) {
		$this->hook = $hook;
		$this->request_handler = $request_handler;
		$this->assets = $assets;
	}

	public function register() {
		add_action( 'load-' . $this->hook, [ $this, 'set_page' ] );
		add_action( 'load-' . $this->hook, [ $this, 'load' ] );
		add_action( 'in_admin_header', [ $this, 'head' ] );
		add_action( $this->hook, [ $this, 'body' ] );
	}

	public function set_page() {
		$this->page = $this->request_handler->handle( new Request() );
	}

	public function load() {
		if ( ! $this->page ) {
			return;
		}

		if ( $this->page instanceof Registrable ) {
			$this->register();
		}

		$screen = get_current_screen();

		if ( $this->page instanceof Helpable && $screen ) {
			foreach ( $this->page->get_help_tabs() as $help ) {
				$screen->add_help_tab( [
					'id'      => $help->get_id(),
					'title'   => $help->get_title(),
					'content' => $help->get_content(),
				] );
			}
		}

		if ( $this->page instanceof Enqueueables ) {
			array_map( [ $this, 'enqueue' ], $this->page->get_assets()->all() );
		}

		foreach ( $this->assets->get_assets()->all() as $asset ) {
			$asset->enqueue();
		}

		do_action( 'ac/admin_scripts', $this->page );

		add_filter( 'screen_settings', [ $this, 'screen_options' ] );
	}

	public function head() {
		if ( $this->page instanceof RenderableHead ) {
			echo $this->page->render_head();
		}
	}

	public function body() {
		if ( $this->page instanceof Renderable ) {
			$view = new View( [
				'content' => $this->page->render(),
			] );

			echo $view->set_template( 'admin/wrap' )->render();
		}
	}

	protected function enqueue( Enqueueable $asset ) {
		$asset->enqueue();
	}

	public function screen_options( $settings ) {
		if ( $this->page instanceof ScreenOptions ) {
			$settings .= sprintf( '<legend>%s</legend>', __( 'Display', 'codepress-admin-columns' ) );

			foreach ( $this->page->get_screen_options() as $screen_option ) {
				$settings .= $screen_option->render();
			}
		}

		return $settings;
	}

}