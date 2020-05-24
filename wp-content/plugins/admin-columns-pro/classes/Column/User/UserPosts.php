<?php

namespace ACP\Column\User;

use AC;

class UserPosts extends AC\Column
	implements AC\Column\AjaxValue {

	public function __construct() {
		$this->set_type( 'column-user_posts' )
		     ->set_label( __( 'Posts by Author', 'codepress-admin-columns' ) );
	}

	public function get_value( $user_id ) {
		$posts = $this->get_raw_value( $user_id );

		if ( empty( $posts ) ) {
			return $this->get_empty_char();
		}

		$count = sprintf( _n( '%s item', '%s items', count( $posts ) ), count( $posts ) );

		return ac_helper()->html->get_ajax_toggle_box_link( $user_id, $count, $this->get_name(), __( 'Hide' ) );
	}

	public function get_ajax_value( $user_id ) {
		$posts = $this->get_raw_value( $user_id );
		$value = [];

		foreach ( $posts as $post_id ) {
			$value[] = $this->get_formatted_value( $post_id, $post_id );
		}

		return implode( ', ', $value );
	}

	/**
	 * @param $user_id
	 *
	 * @return array
	 */
	public function get_raw_value( $user_id ) {
		return get_posts( [
			'fields'         => 'ids',
			'author'         => $user_id,
			'post_type'      => $this->get_setting( 'post_type' )->get_post_type(),
			'posts_per_page' => -1,
		] );
	}

	protected function register_settings() {
		$this->add_setting( new AC\Settings\Column\PostType( $this, true ) )
		     ->add_setting( new AC\Settings\Column\Post( $this ) );
	}

}