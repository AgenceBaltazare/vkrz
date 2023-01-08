<?php

namespace ACP\Editing\Storage;

use AC\MetaType;
use ACP\Editing\Storage;

class Meta implements Storage {

	/**
	 * @var string
	 */
	protected $meta_key;

	/**
	 * @var MetaType
	 */
	private $meta_type;

	public function __construct( $meta_key, MetaType $meta_type ) {
		$this->meta_key = (string) $meta_key;
		$this->meta_type = $meta_type;
	}

	public function get( int $id ) {
		return get_metadata( $this->meta_type->get(), $id, $this->meta_key, true );
	}

	public function update( int $id, $data ): bool {
		return false !== update_metadata( $this->meta_type->get(), $id, $this->meta_key, $data );
	}

}