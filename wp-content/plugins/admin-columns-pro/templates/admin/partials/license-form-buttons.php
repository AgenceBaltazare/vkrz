<?php use ACP\RequestParser; ?>
<span class="buttons">
<?php if ( ! $this->is_license_defined ): ?>
	<button type="submit" class="button" name="action" value="<?= RequestParser::ACTION_DEACTIVATE; ?>"><?php _e( 'Remove', 'codepress-admin-columns' ); ?></button>
<?php endif; ?>
	<button type="submit" class="button" name="action" value="<?= RequestParser::ACTION_UPDATE; ?>"><?php _e( 'Check again', 'codepress-admin-columns' ); ?></button>
</span>