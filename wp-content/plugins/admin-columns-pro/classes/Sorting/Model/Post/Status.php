<?php

namespace ACP\Sorting\Model\Post;

use ACP\Sorting\Model;

class Status extends Model {

	public function get_sorting_vars() {
		add_filter( 'posts_orderby', [ $this, 'orderby_status' ] );

		return [];
	}

	public function orderby_status( $orderby_statement ) {
		global $wpdb;

		$stati = get_post_stati( null, 'objects' );
		$translated_stati = [];

		foreach ( $stati as $key => $post_status ) {
			$key = sanitize_key( $key );
			$translated_stati[ $key ] = $post_status->label;
		}

		natcasesort( $translated_stati );

		$sorted_keys = array_map( function ( $val ) {
			return sprintf( "'%s'", $val );
		}, array_keys( $translated_stati ) );

		return sprintf( 'FIELD(%s, %s) %s', "{$wpdb->posts}.post_status", implode( ',', $sorted_keys ), $this->get_order() );
	}

}