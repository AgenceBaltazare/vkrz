<form action="" method="post">
	<?php wp_nonce_field( 'reset-sorting-preference', '_acnonce' ); ?>
	<input type="submit" class="button" value="<?php _e( 'Reset sorting preferences', 'codepress-admin-columns' ); ?>">
</form>