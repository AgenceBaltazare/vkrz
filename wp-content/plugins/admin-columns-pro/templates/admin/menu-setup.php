<?php

use AC\Admin\Menu;
use AC\View;

/**
 * @var Menu\Item[] $items
 */
$items = $this->menu_items;
?>
<?= ( new View( [ 'license_status' => $this->license_status ] ) )->set_template( 'admin/header' ) ?>

<nav class="cpac-admin-nav">
	<ul class="cpac-step-nav">
		<?php
		foreach ( $items as $item ) : ?>
			<li class="cpac-step-nav__item <?= esc_attr( $item->get_class() ); ?>">
				<?php if ( $item->get_url() ) : ?>
					<a href="<?= esc_url( $item->get_url() ); ?>">
						<?= $item->get_label(); ?>
					</a>
				<?php else: ?>
					<?= $item->get_label(); ?>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>