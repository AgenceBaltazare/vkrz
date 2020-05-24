<?php

namespace ACP\Exception;

use RuntimeException;
use Throwable;

class FailedToReadDirectoryException extends RuntimeException {

	/**
	 * @var string
	 */
	private $path;

	public function __construct( $path, $code = 0, Throwable $previous = null ) {
		parent::__construct( sprintf( 'Could not read directory %s.', $path ), $code, $previous );

		$this->path = $path;
	}

	/**
	 * @return string
	 */
	public function get_path() {
		return $this->path;
	}

}