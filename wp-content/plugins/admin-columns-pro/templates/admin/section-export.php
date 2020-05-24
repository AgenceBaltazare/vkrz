<?php

use ACP\Migrate\Export;
use ACP\Storage\ListScreen\SerializerTypes;

?>
<div class="ac-section -export">
	<div class="ac-section__header">
		<h2 class="ac-section__header__title"><?= __( 'Export', 'codepress-admin-columns' ) ?></h2>
	</div>
	<div class="ac-section__body">
		<p>
			<?= __( 'Select the columns settings you would like to export.', 'codepress-admin-columns' ) ?>
			<?= __( 'The result is a JSON file that can be imported in any WordPress install that uses Admin Columns Pro.', 'codepress-admin-columns' ) ?>
		</p>

		<form method="POST">
			<?php wp_nonce_field( Export\Request::ACTION, Export\Request::NONCE_NAME ); ?>
			<input type="hidden" name="action" value="<?= Export\Request::ACTION ?>">
			<input type="hidden" name="encoder" value="<?= SerializerTypes::JSON ?>">
			<?= $this->table->render() ?>
			<button class="button button-primary" data-export="<?= SerializerTypes::JSON ?>"><?php _e( 'Export To JSON', 'codepress-admin-columns' ); ?></button>
		</form>
	</div>
</div>