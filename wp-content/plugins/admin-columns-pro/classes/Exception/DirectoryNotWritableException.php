<?php

namespace ACP\Exception;

use RuntimeException;
use Throwable;

class DirectoryNotWritableException extends RuntimeException {

	/**
	 * @var string
	 */
	private $path;

	public function __construct( $path, $code = 0, Throwable $previous = null ) {
		parent::__construct( sprintf( 'Directory with path %s is not writable.', $path ), $code, $previous );

		$this->path = $path;
	}

	/**
	 * @return string
	 */
	public function get_path() {
		return $this->path;
	}

}