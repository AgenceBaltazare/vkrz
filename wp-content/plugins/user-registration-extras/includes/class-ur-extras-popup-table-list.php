<?php
/**
 * User Registration Extras Popup Table List
 *
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * EXtras Popup list class.
 */
class User_Registration_Extras_Popup_Table_List extends WP_List_Table {

	/**
	 * Form ID.
	 *
	 * @var int
	 */
	public $popup_type;

	/**
	 * Initialize the popup table list.
	 */
	public function __construct() {

		$page  = ( isset( $_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
		$forms = array(
			'all'			=> 'All Popups',
			'registration' => 'Registration Popups',
			'login'        => 'Login Popups',
		);

		$latest = key( $forms );

		// @TODO::Verify Nonce
		$this->popup_type = ! empty( $_REQUEST['popup_type'] ) ? $_REQUEST['popup_type'] : $latest;

		parent::__construct(
			array(
				'singular' => 'popup',
				'plural'   => 'popups',
				'ajax'     => false,
			)
		);
	}

	/**
	 * No items found text.
	 */
	public function no_items() {
		$add_popup_link = esc_url( admin_url( 'admin.php?page=user-registration-settings&tab=user-registration-extras&section=add-new-popup' ) );
		if ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] === 'active' ) {
			esc_html_e( 'Whoops, it appears you do not have any active popups yet.', 'user-registration-extras' );
			echo '<a href="' . $add_popup_link . '"> Add now? </a>';
		} else {
			esc_html_e( 'Whoops, it appears you do not have any popups yet.', 'user-registration-extras' );
			echo '<a href="' . $add_popup_link . '"> Add now? </a>';
		}
	}

	/**
	 * Get Active popups list table columns.
	 *
	 * @return array Columns.
	 */
	public function get_columns() {

		$columns              = array();
		$columns['cb']        = '<input type="checkbox" />';
		$columns['popup']     = __( 'Popup', 'user-registration-extras' );
		$columns['type']      = __( 'Popup Type', 'user-registration-extras' );
		$columns['shortcode'] = __( 'Shortcode', 'user-registration-extras' );
		$columns['status']    = __( 'Popup Status', 'user-registration-extras' );
		$columns['author']    = __( 'Author', 'user-registration-extras' );
		$columns['cdate']     = __( 'Created Date', 'user-registration-extras' );

		return apply_filters( 'user_registration_extras_popup_list_table_columns', $columns );
	}

	/**
	 * Column cb.
	 *
	 * @param  array $item
	 *
	 * @return string
	 */
	public function column_cb( $items ) {
		return sprintf( '<input type="checkbox" name="%1$s[]" value="%2$s" />', $this->_args['singular'], $items->ID );
	}

	/**
	 * Return extras popup column.
	 *
	 * @param  object $items
	 *
	 * @return string
	 */
	public function column_popup( $items ) {
		$edit_link        = admin_url( 'admin.php?page=user-registration-settings&tab=user-registration-extras&section=add-new-popup&amp;edit-popup=' . $items->ID );
		$title            = _draft_or_post_title( $items->ID );
		$post_type_object = get_post_type_object( 'ur_extras_popup' );
		$post_status      = $items->post_status;

		// Title
		$output = '<strong>';
		if ( 'trash' == $post_status ) {
			$output .= esc_html( $title );
		} else {
			$output .= '<a href="' . esc_url( $edit_link ) . '" class="row-title">' . esc_html( $title ) . '</a>';
		}
		$output .= '</strong>';

		// Get actions
		$actions = array(
			'id' => sprintf( __( 'ID: %d', 'user-registration-extras' ), $items->ID ),
		);

		if ( current_user_can( $post_type_object->cap->edit_post, $items->ID ) && 'trash' !== $post_status ) {
			$actions['edit'] = '<a href="' . esc_url( $edit_link ) . '">' . __( 'Edit', 'user-registration-extras' ) . '</a>';
		}
		if ( current_user_can( $post_type_object->cap->delete_post, $items->ID ) ) {
			if ( 'trash' == $post_status ) {
				$actions['untrash'] = '<a aria-label="' . esc_attr__( 'Restore this item from the Trash', 'user-registration-extras' ) . '" href="' . wp_nonce_url( admin_url( sprintf( $post_type_object->_edit_link . '&amp;action=untrash', $items->ID ) ), 'untrash-post_' . $items->ID ) . '">' . esc_html__( 'Restore', 'user-registration-extras' ) . '</a>';
			} elseif ( EMPTY_TRASH_DAYS ) {
				$actions['trash'] = '<a class="submitdelete" aria-label="' . esc_attr__( 'Move this item to the Trash', 'user-registration-extras' ) . '" href="' . get_delete_post_link( $items->ID ) . '">' . esc_html__( 'Trash', 'user-registration-extras' ) . '</a>';
			}
			if ( 'trash' == $post_status || ! EMPTY_TRASH_DAYS ) {
				$actions['delete'] = '<a class="submitdelete" aria-label="' . esc_attr__( 'Delete this item permanently', 'user-registration-extras' ) . '" href="' . get_delete_post_link( $items->ID, '', true ) . '">' . esc_html__( 'Delete permanently', 'user-registration-extras' ) . '</a>';
			}
		}

		$row_actions = array();

		foreach ( $actions as $action => $link ) {
			$row_actions[] = '<span class="' . esc_attr( $action ) . '">' . $link . '</span>';
		}

		$output .= '<div class="row-actions">' . implode( ' | ', $row_actions ) . '</div>';

		return $output;
	}

	/**
	 * Return status column.
	 *
	 * @param  object $items
	 *
	 * @return string
	 */
	public function column_status( $items ) {

		if ( isset( $_REQUEST['status'] ) && 'trashed' === $_REQUEST['status'] ) {
			return '<span class="user-registration-badge user-registration-badge--danger-subtle">Trashed</span>';
		} else {
			if ( ! isset( $items->popup_status ) || '' === $items->popup_status ) {
				return '<span class="user-registration-badge user-registration-badge--secondary-subtle">Inactive</span>';
			} else {
				return '<span class="user-registration-badge user-registration-badge--success-subtle">Active</span>';
			}
		}
	}

	/**
	 * Return status popup type.
	 *
	 * @param  object $items
	 *
	 * @return string
	 */
	public function column_type( $items ) {
		return ucfirst( $items->popup_type );
	}

	/**
	 * Return created date column.
	 *
	 * @param  object $items
	 *
	 * @return string
	 */
	public function column_cdate( $items ) {
		$post = get_post( $items->ID );

		if ( ! $post ) {
			return;
		}

		$t_time = mysql2date(
			__( 'Y/m/d g:i:s A', 'user-registration-extras' ),
			$post->post_date,
			true
		);
		$m_time = $post->post_date;
		$time   = mysql2date( 'G', $post->post_date )
				  - get_option( 'gmt_offset' ) * 3600;

		$time_diff = time() - $time;

		if ( $time_diff > 0 && $time_diff < 24 * 60 * 60 ) {
			$h_time = sprintf(
				__( '%s ago', 'user-registration-extras' ),
				human_time_diff( $time )
			);
		} else {
			$h_time = mysql2date( __( 'Y/m/d', 'user-registration-extras' ), $m_time );
		}

		return '<abbr title="' . $t_time . '">' . $h_time . '</abbr>';  }

	/**
	 * Return author column.
	 *
	 * @param  object $items
	 *
	 * @return string
	 */
	public function column_author( $items ) {
		$user = get_user_by( 'id', $items->post_author );

		if ( ! $user ) {
			return '<span class="na">&ndash;</span>';
		}

		$user_name = ! empty( $user->data->display_name ) ? $user->data->display_name : $user->data->user_login;

		if ( current_user_can( 'edit_user' ) ) {
			return '<a href="' . esc_url(
				add_query_arg(
					array(
						'user_id' => $user->ID,
					),
					admin_url( 'user-edit.php' )
				)
			) . '">' . esc_html( $user_name ) . '</a>';
		}

		return esc_html( $user_name );
	}


	function column_shortcode( $items ) {

		$shortcode = '[user_registration_popup id="' . $items->ID . '"]';

		return sprintf( '<span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value=\'%s\' class="large-text code"></span>', $shortcode );

	}
	/**
	 * Get a list of sortable columns.
	 *
	 * @return array
	 */
	protected function get_sortable_columns() {
		return apply_filters(
			'user_registration_extras_popup_sortable_columns',
			array(
				'popup'  => array( 'post_title', false ),
				'cdate'  => array( 'cdate', false ),
				'author' => array( 'author', false ),
			)
		);
	}

	/**
	 * Get a list of hidden columns.
	 *
	 * @return array
	 */
	protected function get_hidden_columns() {
		return get_hidden_columns( $this->screen );
	}
	/**
	 * Set _column_headers property for table list
	 */
	protected function prepare_column_headers() {
		$this->_column_headers = array(
			$this->get_columns(),
			array(),
			$this->get_sortable_columns(),
		);
	}

	/**
	 * Prepare table list items.
	 *
	 * @global wpdb $wpdb
	 */
	public function prepare_items( $args = array() ) {

		$per_page     = $this->get_items_per_page( 'user_registration_extras_popups_per_page', 20 );
		$columns      = $this->get_columns();
		$hidden       = $this->get_hidden_columns();
		$sortable     = $this->get_sortable_columns();
		$current_page = $this->get_pagenum();

		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = array();
		$active_items          = array();
		$inactive_items        = array();
		$trashed_items         = array();
		$all_published_items   = array();

		$args = array(
			'post_type'           => 'ur_extras_popup',
			'posts_per_page'      => $per_page,
			'ignore_sticky_posts' => true,
			'paged'               => $current_page,
			'post_status'         => array( 'publish', 'trash' ),
		);

		// Handle the search query.
		if ( ! empty( $_REQUEST['s'] ) ) {
			$args['s'] = sanitize_text_field( trim( wp_unslash( $_REQUEST['s'] ) ) ); // WPCS: sanitization ok, CSRF ok.
		}

		$args['orderby'] = isset( $_REQUEST['orderby'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['orderby'] ) ) : 'date_created'; // WPCS: sanitization ok, CSRF ok.
		$args['order']   = isset( $_REQUEST['order'] ) && 'DESC' === strtoupper( $_REQUEST['order'] ) ? 'DESC' : 'ASC';

		$popups = new WP_Query( $args );

		foreach ( $popups->posts as  $item ) {

			$popup_content = json_decode( $item->post_content );

			$popup_content->ID          = $item->ID;
			$popup_content->created_at  = $item->post_date;
			$popup_content->post_author = $item->post_author;
			$popup_content->post_status = $item->post_status;

			$this->items[] = $popup_content;
		}

		foreach ( $this->items as $item ) {

			if ( 'trash' === $item->post_status ) {
				$trashed_items[] = $item;
			} else {

				if ( ! isset( $item->popup_status ) || '' === $item->popup_status ) {
					$inactive_items[] = $item;
				} else {
					$active_items[] = $item;
				}

				// Filter Popups only in all popups page.
				if( 'all' !== $this->popup_type ) {

					if ( $item->popup_type != $this->popup_type && empty( $_REQUEST['s'] ) ) {
						continue;
					}
				}

				$all_published_items[] = $item;
			}
		}

		// Trashed Items
		if ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] === 'trashed' ) {
			$this->items = $trashed_items;
		}
		// Active Items.
		if ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] === 'active' ) {
			$this->items = $active_items;
		}
		// Inactive Items.
		if ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] === 'inactive' ) {
			$this->items = $inactive_items;
		}

		// Published Items.
		if ( ! isset( $_REQUEST['status'] ) ) {
			$this->items = $all_published_items;
		}

		$this->set_pagination_args(
			array(
				'total_items' => count( $this->items ),
				'per_page'    => $per_page,
				'total_pages' => $popups->max_num_pages,
			)
		);

	}

	/**
	 * Views of the list by status.
	 *
	 * @return string
	 */
	protected function get_views() {
		$status_links   = array();
		$class          = '';
		$trash_count    = 0;
		$active_count   = 0;
		$inactive_count = 0;
		$trash_class    = '';
		$active_class   = '';
		$inactive_class = '';

		if ( isset( $_REQUEST['status'] ) && 'trashed' === $_REQUEST['status'] ) {
			$trash_class = 'current';
		} elseif ( isset( $_REQUEST['status'] ) && 'active' === $_REQUEST['status'] ) {
			$active_class = 'current';
		} elseif ( isset( $_REQUEST['status'] ) && 'active' === $_REQUEST['status'] ) {
			$inactive_class = 'current';
		} else {
			$class = 'current';
		}

		$post_id = array();
		$args    = array(
			'post_type'     => 'ur_extras_popup',
			'post_status'   => array( 'publish', 'trash' ),
			'__post_not_in' => $post_id,
		);

		$popups = new WP_Query( $args );

		foreach ( $popups->posts as $popup ) {
			$post_id[] = $popup->ID;

			if ( 'publish' === $popup->post_status ) {
				$popup_content = json_decode( $popup->post_content );

				if ( ! isset( $popup_content->popup_status ) || '' === $popup_content->popup_status ) {
					$inactive_count++;
				} else {
					$active_count++;
				}
			} else {
				$trash_count++;
			}
		}
		$total_count = $active_count + $inactive_count;

		/* translators: %s: count */
		$status_links['all']      = "<a href='admin.php?page=user-registration-settings&tab=user-registration-extras&section=popups' class=" . $class . '>' . sprintf( _nx( 'All <span class="count">(%s)</span>', 'All <span class="count">(%s)</span>', $total_count, 'codes', 'user-registration-extras' ), number_format_i18n( $total_count ) ) . '</a>';
		$status_links['active']   = "<a href='admin.php?page=user-registration-settings&tab=user-registration-extras&section=popups&status=active' class=" . $active_class . '>' . sprintf( _nx( 'Active <span class="count">(%s)</span>', 'Active <span class="count">(%s)</span>', $active_count, 'codes', 'user-registration-extras' ), number_format_i18n( $active_count ) ) . '</a>';
		$status_links['inactive'] = "<a href='admin.php?page=user-registration-settings&tab=user-registration-extras&section=popups&status=inactive' class=" . $inactive_class . '>' . sprintf( _nx( 'In Active <span class="count">(%s)</span>', 'Inactive <span class="count">(%s)</span>', $inactive_count, 'codes', 'user-registration-extras' ), number_format_i18n( $inactive_count ) ) . '</a>';

		if ( $trash_count > 0 ) {
			$status_links['trashed'] = "<a href='admin.php?page=user-registration-settings&tab=user-registration-extras&section=popups&status=trashed' class=" . $trash_class . '>' . sprintf( _nx( 'Trash <span class="count">(%s)</span>', 'Trash <span class="count">(%s)</span>', $trash_count, 'codes', 'user-registration-extras' ), number_format_i18n( $trash_count ) ) . '</a>';
		}

		return $status_links;
	}

	/**
	 * Get bulk actions.
	 *
	 * @return array
	 */
	protected function get_bulk_actions() {
		if ( isset( $_GET['status'] ) && 'trashed' == $_GET['status'] ) {
			return array(
				'untrash' => __( 'Restore', 'user-registration-extras' ),
				'delete'  => __( 'Delete permanently', 'user-registration-extras' ),
			);
		}

		return array(
			'trash' => __( 'Move to trash', 'user-registration-extras' ),
		);
	}

	/**
	 * Extra controls to be displayed between bulk actions and pagination.
	 *
	 * @param string $which
	 */
	protected function extra_tablenav( $which ) {
		if ( 'top' == $which && isset( $_GET['status'] ) && 'trashed' == $_GET['status'] && current_user_can( 'delete_posts' ) ) {
			echo '<div class="alignleft actions"><a id="delete_all" class="button apply" href="' . esc_url( wp_nonce_url( admin_url( 'admin.php?page=user-registration-settings&tab=user-registration-extras&section=popups&status=trashed&empty_trash=1' ), 'empty_trash' ) ) . '">' . __( 'Empty trash', 'user-registration-extras' ) . '</a></div>';
		}
	}
}
