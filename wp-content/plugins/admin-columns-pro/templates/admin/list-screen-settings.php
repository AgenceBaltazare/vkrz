<?php

use AC\Form\Element\Select;
use ACP\Bookmark\Setting\PreferredSegment;
use ACP\Sorting\Settings\ListScreen\PreferredSort;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<section class="ac-setbox ac-ls-settings ac-section -closable" data-section="ls-settings">
	<header class="ac-section__header">
		<div class="ac-setbox__header__title"><?= __( 'Settings', 'codepress-admin-columns' ); ?>
			<small>(<?= __( 'optional', 'codepress-admin-columns' ); ?>)</small>
		</div>
	</header>
	<form data-form-part="preferences">

		<div class="ac-setbox__row">
			<div class="ac-setbox__row__th">
				<label><?= __( 'Conditionals', 'codepress-admin-columns' ); ?></label>
				<small><?= __( 'Make this column set available only for specific users or roles.', 'codepress-admin-columns' ); ?></small>
			</div>
			<div class="ac-setbox__row__fields">
				<div class="ac-setbox__row__fields__inner">
					<fieldset>
						<div class="row roles">
							<label for="layout-roles-<?php echo $this->id; ?>" class="screen-reader-text">
								<?php _e( 'Roles', 'codepress-admin-columns' ); ?>
								<span>(<?php _e( 'optional', 'codepress-admin-columns' ); ?>)</span>
							</label>

							<?php echo $this->select_roles; ?>

						</div>
						<div class="row users">
							<label for="layout-users-<?php echo $this->id; ?>" class="screen-reader-text">
								<?php _e( 'Users' ); ?>
								<span>(<?php _e( 'optional', 'codepress-admin-columns' ); ?>)</span>
							</label>

							<?php echo $this->select_users; ?>
						</div>
					</fieldset>
				</div>
			</div>
		</div>

		<div class="ac-setbox__row" id="hide-on-screen">
			<div class="ac-setbox__row__th">
				<label><?= __( 'Hide on screen', 'codepress-admin-columns' ); ?></label>
				<small><?= __( 'Select items to hide from the list table screen.', 'codepress-admin-columns' ); ?></small>
			</div>
			<div class="ac-setbox__row__fields">
				<div class="ac-setbox__row__fields__inner">
					<div class="checkbox-labels checkbox-labels vertical">

						<?= $this->hide_on_screen; ?>

					</div>
				</div>
			</div>
		</div>

		<?php
		$number_of_preferences = count( array_filter( [ $this->can_sort, $this->can_bookmark, $this->can_horizontal_scroll ] ) );
		?>

		<?php if ( $number_of_preferences > 0 ) : ?>

			<div class="ac-setbox__row">
				<div class="ac-setbox__row__th">
					<label><?= __( 'Preferences', 'codepress-admin-columns' ); ?></label>
					<small><?= __( 'Set default settings that users will see when they visit the list table.', 'codepress-admin-columns' ); ?></small>
				</div>

				<div class="ac-setbox__row__fields -has-subsettings -subsetting-total-<?= $number_of_preferences; ?>">
					<?php if ( $this->can_horizontal_scroll ) : ?>
						<?php
						$pref_hs = isset( $this->preferences['horizontal_scrolling'] ) ? $this->preferences['horizontal_scrolling'] : 'off';
						?>
						<div class="ac-setbox__row -sub -horizontal-scrolling">
							<div class="ac-setbox__row__th">
								<label><?= __( 'Horizontal Scrolling', 'codepress-admin-columns' ); ?></label>
								<?php echo $this->tooltip_hs->get_label(); ?>
								<?php echo $this->tooltip_hs->get_instructions(); ?>
							</div>
							<div class="ac-setbox__row__fields">
								<div class="ac-setbox__row__fields__inner">
									<div class="radio-labels radio-labels">
										<label class="ac-setting-input_filter"><input name="horizontal_scrolling" type="radio" value="on" <?php checked( $pref_hs, 'on' ); ?>><?= __( 'Yes' ); ?></label>
										<label class="ac-setting-input_filter"><input name="horizontal_scrolling" type="radio" value="off" <?php checked( $pref_hs, 'off' ); ?>><?= __( 'No' ); ?></label>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( $this->can_sort ) : ?>
						<?php
						$selected_order_by = isset( $this->preferences[ PreferredSort::FIELD_SORTING ] )
							? $this->preferences[ PreferredSort::FIELD_SORTING ]
							: 0;

						$selected_order = isset( $this->preferences[ PreferredSort::FIELD_SORTING_ORDER ] )
							? $this->preferences[ PreferredSort::FIELD_SORTING_ORDER ]
							: 'asc';
						?>
						<div class="ac-setbox__row -sub -sorting" data-setting="sorting-preference">
							<div class="ac-setbox__row__th">
								<label><?= __( 'Sorting', 'codepress-admin-columns' ); ?></label>
							</div>
							<div class="ac-setbox__row__fields">
								<div class="ac-setbox__row__fields__inner">
									<div class="radio-labels radio-labels">
										<?php
										$select = new Select( PreferredSort::FIELD_SORTING, [
											0 => __( 'Default' ),
										] );
										echo $select->set_attribute( 'data-sorting', $selected_order_by );

										$select = new Select( PreferredSort::FIELD_SORTING_ORDER, [
											'asc'  => __( 'Ascending' ),
											'desc' => __( 'Descending' ),
										] );
										echo $select->set_class( 'sorting_order' )->set_value( $selected_order );

										?>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $this->can_bookmark ) : ?>

						<?php
						$segments = $this->segments;

						$selected_filter_segment = isset( $this->preferences[ PreferredSegment::FIELD_SEGMENT ] )
							? $this->preferences[ PreferredSegment::FIELD_SEGMENT ]
							: '';
						?>

						<div class="ac-setbox__row -sub -predefinedfilters" data-setting="filter-segment-preference">
							<div class="ac-setbox__row__th">
								<label><?= __( 'Pre-applied Filters', 'codepress-admin-columns' ); ?></label>
								<?php echo $this->tooltip_filters->get_label(); ?>
								<?php echo $this->tooltip_filters->get_instructions(); ?>
							</div>
							<div class="ac-setbox__row__fields">
								<div class="ac-setbox__row__fields__inner">
									<?php if ( ! empty( $segments ) ): ?>
										<?php
										$select = new Select( PreferredSegment::FIELD_SEGMENT, [ '' => __( 'Default', 'codepress-admin-columns' ) ] + $segments );
										echo $select->set_value( $selected_filter_segment );
										?>
									<?php else: ?>
										<p class="ac-setbox__descriptive">
											<?php _e( "No public saved filters available.", 'codepress-admin-columns' ); ?>
										</p>
									<?php endif; ?>
								</div>
							</div>
						</div>

					<?php endif; ?>

				</div>
			</div>

		<?php endif; ?>

	</form>
</section>