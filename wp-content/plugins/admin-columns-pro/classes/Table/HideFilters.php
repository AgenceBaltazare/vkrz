<?php

namespace ACP\Table;

use AC\ListScreen;
use AC\Registrable;
use ACP\Settings\ListScreen\HideOnScreen;

final class HideFilters implements Registrable {

	public function register() {
		add_action( 'ac/admin_head', [ $this, 'admin_head' ] );
	}

	public function admin_head( ListScreen $listScreen ) {
		if ( ( new HideOnScreen\Filters() )->is_hidden( $listScreen ) ) {
			?>
			<style type="text/css">
				[class="alignleft actions"] {
					display: none !important;
				}
			</style>
			<?php
		}
	}

}