<?php

namespace ACP\Editing\Model\Post;

use ACP\Editing\Model;

class Content extends Model\Post {

	public function get_view_settings() {
		return [
			'type' => 'textarea',
		];
	}

	public function save( $id, $value ) {
		return $this->update_post( $id, [ 'post_content' => $value ] );
	}

}