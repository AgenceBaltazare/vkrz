<?php
/**
 * Plugins Functions and Hooks
 *
 * @package User Registration Customize My Account
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'urcma_build_label' ) ) {
	/**
	 * Build endpoint label by name
	 *
	 * @since 1.0.0
	 * @param string $name Name of the endpoint.
	 * @return string
	 */
	function urcma_build_label( $name ) {

		$label = preg_replace( '/[^a-z]/', ' ', $name );
		$label = trim( $label );
		$label = ucfirst( $label );

		return $label;
	}
}

if ( ! function_exists( 'urcma_get_default_endpoint_options' ) ) {
	/**
	 * Get default options for new endpoints
	 *
	 * @since 1.0.0
	 * @param string $endpoint Name of the endpoint.
	 * @return array
	 */
	function urcma_get_default_endpoint_options( $endpoint ) {

		$endpoint_name = urcma_build_label( $endpoint );

		// build endpoint options.
		$options = array(
			'slug'      => $endpoint,
			'active'    => true,
			'label'     => $endpoint_name,
			'icon'      => '',
			'content'   => '',
			'usr_roles' => '',
		);

		return apply_filters( 'urcma_get_default_endpoint_options', $options );
	}
}

if ( ! function_exists( 'urcma_admin_print_endpoint_field' ) ) {
	/**
	 * Print endpoint field options
	 *
	 * @since 1.0.0
	 * @param array $args Template args array.
	 */
	function urcma_admin_print_endpoint_field( $args ) {

		// let third part filter template args.
		$args = apply_filters( 'urcma_admin_print_endpoint_field', $args );
		extract( $args );

		include URCMA_TEMPLATE_PATH . '/admin/endpoint-item.php';
	}
}

if ( ! function_exists( 'urcma_is_default_item' ) ) {
	/**
	 * Check if an item is a default
	 *
	 * @since 1.0.0
	 * @param string $item The endpoint to be checked.
	 * @return boolean
	 */
	function urcma_is_default_item( $item ) {
		$defaults = URCMA()->items->get_default_items();
		return array_key_exists( $item, $defaults );
	}
}


if ( ! function_exists( 'urcma_is_plugin_item' ) ) {
	/**
	 * Check if an item is a plugin item
	 *
	 * @since 1.0.0
	 * @param string $item The endpoint to be checked.
	 * @return boolean
	 */
	function urcma_is_plugin_item( $item ) {
		$plugin_endpoint = URCMA()->items->get_plugin_items();
		return array_key_exists( $item, $plugin_endpoint );
	}
}


if ( ! function_exists( 'urcma_get_editable_roles' ) ) {
	/**
	 * Get editable roles for endpoints
	 *
	 * @since 1.0.0
	 * @return array
	 */
	function urcma_get_editable_roles() {
		// get user role.
		$roles     = get_editable_roles();
		$usr_roles = array();
		foreach ( $roles as $key => $role ) {
			if ( empty( $role['capabilities'] ) ) {
				continue;
			}
			$usr_roles[ $key ] = $role['name'];
		}

		return $usr_roles;
	}
}

if ( ! function_exists( 'urcma_get_icon_list' ) ) {
	/**
	 * Get FontAwesome icon list
	 *
	 * @since 1.0.0
	 * @return array
	 */
	function urcma_get_icon_list() {
		if ( file_exists( URCMA_DIR . 'assets/icons/icon-list.php' ) ) {
			return include URCMA_DIR . 'assets/icons/icon-list.php';
		}

		return array();
	}
}


if ( ! function_exists( 'urcma_item_already_exists' ) ) {
	/**
	 * Check if item already exists
	 *
	 * @since 1.0.0
	 * @param string $endpoint The new endpoint to be tested.
	 * @return boolean
	 */
	function urcma_item_already_exists( $endpoint ) {

		// check first in key.
		$field_key = URCMA()->items->get_items_keys();
		$exists    = in_array( $endpoint, $field_key, true );

		// check also in slug.
		if ( ! $exists ) {
			$endpoint_slug = URCMA()->items->get_items_slug();
			$exists        = in_array( $endpoint, $endpoint_slug );
		}

		return $exists;
	}
}

if ( ! function_exists( 'urcma_create_field_key' ) ) {

	/**
	 * Create field key
	 *
	 * @since 1.0.0
	 * @param string $key Key for the endpoint.
	 * @return string
	 */
	function urcma_create_field_key( $key ) {

		// build endpoint key.
		$field_key = strtolower( $key );
		$field_key = trim( $field_key );
		// clear from space and add.
		$field_key = sanitize_title( $field_key );

		return $field_key;
	}
}

if ( ! function_exists( 'urcma_save_endpoint_options' ) ) {

	/**
	 * Get and save the endpoint options.
	 *
	 * @since 1.0.0
	 * @param string $endpoint Name of the endpoint.
	 * @param array  $option_id Option Id of endpoint.
	 * @var array $_POST
	 */
	function urcma_save_endpoint_options( $endpoint, $option_id ) {

		$options           = isset( $_POST[ $option_id . '_' . $endpoint ] ) ? $_POST[ $option_id . '_' . $endpoint ] : urcma_get_default_endpoint_options( $endpoint );
		$options['label']  = stripslashes( $options['label'] );
		$options['active'] = isset( $options['active'] );

		if ( isset( $options['url'] ) && ! isset( $options['slug'] ) ) {
			$options['url']          = esc_url_raw( $options['url'] );
			$options['target_blank'] = isset( $options['target_blank'] );
		} else {
			$options['slug']    = ( isset( $options['slug'] ) && ! empty( $options['slug'] ) ) ? urcma_create_field_key( $options['slug'] ) : $endpoint;
			$options['content'] = stripslashes( $options['content'] );

			// synchronize ur options.
			update_option( 'user_registration_myaccount_' . str_replace( '-', '_', $endpoint ) . '_endpoint', $options['slug'] );
		}

		update_option( $option_id . '_' . $endpoint, $options );
	}
}

if ( ! function_exists( 'urcma_update_fields' ) ) {
	/**
	 * Save the admin field
	 *
	 * @return mixed
	 * @since 1.0.0
	 * @var array $_POST
	 */
	function urcma_update_fields() {

		if ( isset( $_POST['urcma_endpoint'] ) ) {
			$value = $_POST['urcma_endpoint'];

			$decoded_values = json_decode( stripslashes( $value ), true );
			$to_save        = array();

			foreach ( $decoded_values as $decoded_value ) {

				if ( ! isset( $decoded_value['id'] ) ) {
					continue;
				}

				// check for master key.
				$id = urcma_create_field_key( $decoded_value['id'] );

				$to_save[ $id ]         = array();
				$to_save[ $id ]['type'] = $decoded_value['type'];

				// save endpoint.
				urcma_save_endpoint_options( $id, 'urcma_endpoint' );
			}

			// handle also removed field.
			urcma_delete_endpoints( 'urcma_endpoint' );

			// reset options for rewrite rules.
			update_option( 'urcma-flush-rewrite-rules', 1 );

			update_option( 'urcma_endpoint', json_encode( $to_save ) );
			return json_encode( $to_save );
		}
	}
}

if ( ! function_exists( 'urcma_delete_endpoints' ) ) {

	/**
	 * Delete removed fields
	 *
	 * @param string $option_id Option Id of endpoint.
	 * @param array  $remove_endpoint endpoint to remove.
	 *
	 * @since 1.0.0
	 */
	function urcma_delete_endpoints( $option_id, $remove_endpoint = array() ) {

		if ( empty( $remove_endpoint ) ) {
			// get fields removed if any.
			$remove_endpoint = isset( $_POST[ $option_id . '_remove_endpoint' ] ) ? $_POST[ $option_id . '_remove_endpoint' ] : '';
			$remove_endpoint = explode( ',', $remove_endpoint );
		}

		if ( ! is_array( $remove_endpoint ) ) {
			return;
		}

		foreach ( $remove_endpoint as $key ) {
			delete_option( $option_id . '_' . $key );
			// delete ur options if any.
			delete_option( 'user_registration_myaccount_' . str_replace( '-', '_', $key ) . '_endpoint' );
		}
	}
}


if ( ! function_exists( 'urcma_get_current_endpoint' ) ) {
	/**
	 * Check if and endpoint is active on frontend. Used for add class 'active' on account menu in frontend
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function urcma_get_current_endpoint() {

		global $wp;

		$current = 'dashboard';
		foreach ( UR()->query->get_query_vars() as $key => $value ) {
			if ( isset( $wp->query_vars[ $key ] ) ) {
				$current = $key;
			}
		}

		return apply_filters( 'urcma_get_current_endpoint', $current );
	}
}


if ( ! function_exists( 'urcma_get_endpoint_by' ) ) {
	/**
	 * Get endpoint by a specified key
	 *
	 * @since 1.0.0
	 * @param string $value value.
	 * @param string $key Can be key or slug.
	 * @param array  $items Endpoint array.
	 * @return array
	 */
	function urcma_get_endpoint_by( $value, $key = 'key', $items = array() ) {

		$accepted = apply_filters( 'urcma_get_endpoint_by_accepted_key', array( 'key', 'slug' ) );

		if ( ! in_array( $key, $accepted ) ) {
			return array();
		}

		empty( $items ) && $items = URCMA()->items->get_items();
		$find                     = array();

		foreach ( $items as $id => $item ) {
			if ( ( $key == 'key' && $id == $value ) || ( isset( $item[ $key ] ) && $item[ $key ] == $value ) ) {
				$find[ $id ] = $item;
				continue;
			} elseif ( isset( $item['children'] ) ) {
				foreach ( $item['children'] as $child_id => $child ) {
					if ( ( $key == 'key' && $value == $child_id ) || ( isset( $child[ $key ] ) && $child[ $key ] == $value ) ) {
						$find[ $child_id ] = $child;
						continue;
					}
				}
				continue;
			}
		}
		return apply_filters( 'urcma_get_endpoint_by_result', $find );
	}
}

add_action( 'urcma_print_single_endpoint', 'urcma_print_single_endpoint', 10, 2 );

if ( ! function_exists( 'urcma_print_single_endpoint' ) ) {
	/**
	 * Print single endpoint on front menu
	 *
	 * @since 1.0.0
	 * @param string $endpoint Name of endpoint.
	 * @param array  $options Options for endpoint.
	 */
	function urcma_print_single_endpoint( $endpoint, $options ) {

		if ( ! isset( $options['url'] ) ) {
			$url                             = get_permalink( ur_get_page_id( 'myaccount' ) );
			$endpoint != 'dashboard' && $url = ur_get_endpoint_url( $endpoint, '', $url );
		} else {
			$url = esc_url( $options['url'] );
		}
		// check if endpoint is active.
		$current = urcma_get_current_endpoint();
		$classes = array(
			'user-registration-MyAccount-navigation-link',
			'user-registration-MyAccount-navigation-link--' . $endpoint,
		);

		( $endpoint == $current ) && $classes[] = 'is-active';

		if ( empty( $options['active'] ) ) {
			$classes[] = 'hide';
		}

		$classes = apply_filters( 'urcma_endpoint_menu_class', $classes, $endpoint, $options );

		// build args array.
		$args = apply_filters(
			'urcma_print_single_endpoint_args',
			array(
				'url'      => $url,
				'endpoint' => $endpoint,
				'options'  => $options,
				'classes'  => $classes,
			)
		);

		ur_get_template( 'urcma-myaccount-menu-item.php', $args, '', URCMA_DIR . 'templates/' );
	}
}
