<?php
function formatContenderHtml( $tournament, $v_id, $index ) {
	ob_start();
	?>
    <a data-contender-tournament="<?= $tournament ?>"
       data-contender-chosen="<?= $v_id ?>"
       id="c_<?= $index ?>"
    >
		<?php
		echo get_the_post_thumbnail( $v_id, 'full', array( 'class' => 'img-fluid' ) );
		?>
        <h2 class="title-contender">
			<?php echo get_the_title( $v_id ); ?>
        </h2>
    </a>
	<?php
	return ob_get_clean();
}

