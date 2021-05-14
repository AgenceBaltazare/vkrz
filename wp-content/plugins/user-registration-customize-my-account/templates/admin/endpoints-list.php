<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$icon_list = urcma_get_icon_list();
$usr_roles = urcma_get_editable_roles();

?>

<div class="urcma-general-settings-container">
	<div id="urcma-account-management" class="urcma-account-management-box">
		<header id="urcma-account-management-head" class="urcma-account-management-header">
			<h2><?php _e( $option['title'], 'user-registration-customize-my-account' ); ?></h2>
			<div class="ur-button-container">
				<button type="button" class="button button-secondary button-large add_new_field" data-target="endpoint"><?php echo __( 'Add Endpoint', 'user-registration-customize-my-account' ); ?></button>
			</div>
		</header>
		<div class="urcma-endpoints-container">
			<div class="ur-sidebar urcma-endpoints-list">
				<nav class="ur-sidebar-nav-wrapper urcma-endpoint-tabs">
					<!-- Endpoints -->
					<?php
					foreach ( $endpoints as $key => $endpoint ) {
						?>
						<div class="ur-sidebar-nav-tab urcma-endpoint-selector" id="<?php echo $key; ?>" data-id="<?php echo $endpoint['label']; ?>" data-type="endpoint">
							<?php echo $endpoint['label']; ?>
							<svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" role="img" aria-hidden="true" focusable="false"><path d="M13,8c0.6,0,1-0.4,1-1s-0.4-1-1-1s-1,0.4-1,1S12.4,8,13,8z M5,6C4.4,6,4,6.4,4,7s0.4,1,1,1s1-0.4,1-1S5.6,6,5,6z M5,10 c-0.6,0-1,0.4-1,1s0.4,1,1,1s1-0.4,1-1S5.6,10,5,10z M13,10c-0.6,0-1,0.4-1,1s0.4,1,1,1s1-0.4,1-1S13.6,10,13,10z M9,6 C8.4,6,8,6.4,8,7s0.4,1,1,1s1-0.4,1-1S9.6,6,9,6z M9,10c-0.6,0-1,0.4-1,1s0.4,1,1,1s1-0.4,1-1S9.6,10,9,10z"></path></svg>
						</div>
							<?php
					}
					?>
					<input type="hidden" class="endpoints-order" name="<?php echo $option['id']; ?>" value="" />
					<input type="hidden" class="endpoint-to-remove" name="<?php echo $option['id']; ?>_remove_endpoint" value="" />
				</nav>
			</div>
			<div class='ur-content-wrap urcma-endpoints-wrapper'>
				<?php
				if ( ! empty( $form_data ) && isset( $_GET['edit-registration'] ) && is_numeric( $_GET['edit-registration'] ) ) {
					$this->get_edit_form_field( $form_data );
				} else {
					?>
					<div class="urcma-endpoints-options-wrapper">
						<?php
						foreach ( $endpoints as $key => $endpoint ) {
							// build args array
							$args = array(
								'endpoint'  => $key,
								'options'   => $endpoint,
								'id'        => $option['id'],
								'icon_list' => $icon_list,
								'usr_roles' => $usr_roles,
								'value'     => isset( $value[ $key ] ) ? $value[ $key ] : array(),
							);

							// get type
							$type = isset( $value[ $key ] ) ? $value[ $key ]['type'] : 'endpoint';
							call_user_func( 'urcma_admin_print_' . $type . '_field', $args );
							?>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
