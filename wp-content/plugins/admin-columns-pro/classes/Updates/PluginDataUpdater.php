<?php

namespace ACP\Updates;

use ACP\API;
use ACP\Storage;
use ACP\Type\ActivationToken;
use ACP\Type\SiteUrl;

class PluginDataUpdater {

	/**
	 * @var API
	 */
	private $api;

	/**
	 * @var SiteUrl
	 */
	private $site_url;

	/**
	 * @var Storage\PluginsData
	 */
	private $storage;

	public function __construct( API $api, SiteUrl $site_url, Storage\PluginsData $storage ) {
		$this->api = $api;
		$this->site_url = $site_url;
		$this->storage = $storage;
	}

	public function update( ActivationToken $token = null, $force_update_check = false ) {
		$response = $this->api->dispatch(
			new API\Request\ProductsUpdate( $this->site_url, $token )
		);

		if ( ! $response || $response->has_error() ) {
			return;
		}

		$this->storage->save( (array) $response->get_body() );

		if ( $force_update_check ) {
			wp_clean_plugins_cache();
			wp_update_plugins();
		}
	}

}